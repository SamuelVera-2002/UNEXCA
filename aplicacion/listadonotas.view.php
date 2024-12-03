<!DOCTYPE html>
<?php
require 'functions.php';

$permisos = ['Administrador','Profesor','Estudiante'];
permisos($permisos);
//consulta las materias
$materias = $conn->prepare("select * from materias");
$materias->execute();
$materias = $materias->fetchAll();

//consulta de grados
$grados = $conn->prepare("select * from grados");
$grados->execute();
$grados = $grados->fetchAll();

//consulta las secciones
$secciones = $conn->prepare("select * from secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();
?>
<html>
<head>
    <title>Consulta de Notas</title>
    <meta name="description" content="UNEXCA - matriculación y control de notas" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>
<div class="header">
    <div class="text-content">
        <h1>Centro de Educación Inicial - José Joaquín Veroes</h1>
        <h3>Usuario: <?php echo $_SESSION["username"] ?></h3>
    </div>
    <img src="./img/Logo JJV-Photoroom.png" alt="Logo" class="logo">
</div>
<nav class="sidebar">
        <a href="inicio.view.php"><i></i>Inicio</a>
        <a href="alumnos.view.php"><i></i>Registro de Estudiantes</a>
        <a href="listadoalumnos.view.php"><i></i>Listado de Estudiantes</a>
        <a href="notas.view.php"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php" class="active"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">
    <div class="panel">
        <h1>Consulta de Notas</h1>
        <?php
        if (!isset($_GET['consultar'])) {
            ?>
            <p>Seleccione el grado, la materia y la sección</p>
            <form method="get" class="form" action="listadonotas.view.php">
                <label>Seleccione el Grado</label><br>
                <select name="grado" required>
                    <?php foreach ($grados as $grado): ?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>
                <label>Seleccione la Materia</label><br>
                <select name="materia" required>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['id'] ?>"><?php echo $materia['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>

                <br><br>
                <label>Seleccione la Sección</label><br><br>

                <?php foreach ($secciones as $seccion): ?>
                    <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">Sección <?php echo $seccion['nombre'] ?>
                <?php endforeach; ?>

                <br><br>
                <button type="submit" name="consultar" value="1">Consultar Notas</button></a>
                <br><br>
            </form>
            <?php
        }
        ?>
        <hr>

        <?php
        if (isset($_GET['consultar'])) {
            $id_materia = $_GET['materia'];
            $id_grado = $_GET['grado'];
            $id_seccion = $_GET['seccion'];

            // Extrayendo el número de evaluaciones para esa materia seleccionada
            $num_eval = $conn->prepare("SELECT num_evaluaciones FROM materias WHERE id = " . $id_materia);
            $num_eval->execute();
            $num_eval = $num_eval->fetch();
            $num_eval = $num_eval['num_evaluaciones'];

            // Mostrando el cuadro de notas de todos los alumnos del grado seleccionado
            $sqlalumnos = $conn->prepare("
                SELECT a.id, a.apellidos, a.nombres, b.nota, b.observaciones, AVG(b.nota) as promedio 
                FROM alumnos as a 
                LEFT JOIN notas as b ON a.id = b.id_alumno
                WHERE a.id_grado = $id_grado AND a.id_seccion = $id_seccion AND a.estado_elimination = 'activo'
                GROUP BY a.id
            ");
            $sqlalumnos->execute();
            $alumnos = $sqlalumnos->fetchAll();
            $num_alumnos = $sqlalumnos->rowCount();
            $promediototal = 0.0;
            ?>
            <br>
            <a href="listadonotas.view.php"><strong><< Volver</strong></a>
            <br>
            <br>

            <table class="table" cellpadding="0" cellspacing="0">
                <tr>
                    <th>N° de lista</th><th>Apellidos</th><th>Nombres</th>
                    <?php
                    for ($i = 1; $i <= $num_eval; $i++) {
                        echo '<th>Nota ' . $i . '</th>';
                    }
                    ?>
                    <th>Promedio</th>
                    <th>Observaciones</th>
                </tr>
                <?php 
                $num_lista = 1; // Inicializar contador
                foreach ($alumnos as $alumno): ?>
                    <!-- Campos ocultos necesarios para realizar el insert-->
                    <tr>
                        <td align="center"><?php echo $num_lista++; ?></td>
                        <td><?php echo $alumno['apellidos']; ?></td>
                        <td><?php echo $alumno['nombres']; ?></td>
                        <?php
                        // Escribiendo las notas en columnas
                        $notas = $conn->prepare("SELECT id, nota FROM notas WHERE id_alumno = " . $alumno['id'] . " AND id_materia = " . $id_materia);
                        $notas->execute();
                        $notas = $notas->fetchAll();

                        foreach ($notas as $eval => $nota) {
                            echo '<td align="center"><input type="hidden" 
                                    name="nota' . $eval . '" value="' . $nota['nota'] . '">' . $nota['nota'] . '</td>';
                        }

                        echo '<td align="center">' . number_format($alumno['promedio'], 2) . '</td>';
                        $promediototal += number_format($alumno['promedio'], 2);
                        echo '<td>' . $alumno['observaciones'] . '</td>';
                        ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">
                        <?php
                        for ($i = 0; $i < $num_eval; $i++) {
                            echo '<td><div class="text-center" id="promedio' . $i . '"><div></td>';
                        }
                        ?>
                        <td align="center"><?php echo number_format($promediototal / $num_alumnos, 2); ?></td>
                    </tr>
            </table>
            <br>
            <?php
        }
        ?>
    </div>
</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>
<script>
    <?php
    for($i = 0; $i < $num_eval; $i++){
        echo 'var values'.$i.' = [];
        var promedio'.$i.';
    var valor'.$i.' = 0;
    var nota'.$i.' = document.getElementsByName("nota'.$i.'");
    for(var i = 0; i < nota'.$i.'.length; i++) {
        valor'.$i.' += parseFloat(nota'.$i.'[i].value);
    }
    promedio'.$i.' = (valor'.$i.' / parseFloat(nota'.$i.'.length));
    document.getElementById("promedio'.$i.'").innerHTML = (promedio'.$i.').toFixed(2);';

    }
    ?>
</script>

</html>