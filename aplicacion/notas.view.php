<!DOCTYPE html>
<?php
require 'functions.php';
//arreglo de permisos
$permisos = ['Administrador','Profesor'];
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
<title>Notas | Registro de Notas</title>
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
        <a href="notas.view.php" class="active"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">
    <div class="panel">
        <h1>Registro y Modificación Notas</h1>
        <?php
        if (!isset($_GET['revisar'])) {
            ?>
            <form method="get" class="form" action="notas.view.php">
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
                <label>Seleccione la Sección</label><br>

                <?php foreach ($secciones as $seccion): ?>
                    <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">Sección <?php echo $seccion['nombre'] ?>
                <?php endforeach; ?>
                <br><br>
                <button type="submit" name="revisar" value="1">Ingresar Notas</button>
                <a class="btn-link" href="listadonotas.view.php">Consultar Notas</a>
                <br><br>
            </form>
            <?php
        }
        ?>
        <hr>

        <?php
        if (isset($_GET['revisar'])) {
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
                SELECT a.id, a.apellidos, a.nombres, b.nota, AVG(b.nota) as promedio, b.observaciones 
                FROM alumnos AS a 
                LEFT JOIN notas AS b ON a.id = b.id_alumno
                WHERE a.id_grado = $id_grado AND a.id_seccion = $id_seccion AND a.estado_elimination = 'activo'
                GROUP BY a.id
            ");
            $sqlalumnos->execute();
            $alumnos = $sqlalumnos->fetchAll();
            $num_alumnos = $sqlalumnos->rowCount();

            ?>
            <br>
            <a href="notas.view.php"><strong><< Volver</strong></a>
            <br><br>
            <form action="procesarnota.php" method="post">
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>N° de lista</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <?php
                        for ($i = 1; $i <= $num_eval; $i++) {
                            echo '<th>Nota ' . $i . '</th>';
                        }
                        ?>
                        <th>Promedio</th>
                        <th>Observaciones</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php 
                    $num_lista = 1; // Inicializar contador
                    foreach ($alumnos as $index => $alumno): ?>
                        <input type="hidden" value="<?php echo $num_alumnos ?>" name="num_alumnos">
                        <input type="hidden" value="<?php echo $alumno['id'] ?>" name="<?php echo 'id_alumno' . $index ?>">
                        <input type="hidden" value="<?php echo $num_eval ?>" name="num_eval">
                        <input type="hidden" value="<?php echo $id_materia ?>" name="id_materia">
                        <input type="hidden" value="<?php echo $id_grado ?>" name="id_grado">
                        <input type="hidden" value="<?php echo $id_seccion ?>" name="id_seccion">
                        <tr>
                            <td align="center"><?php echo $num_lista++; ?></td>
                            <td><?php echo $alumno['apellidos']; ?></td>
                            <td><?php echo $alumno['nombres']; ?></td>
                            <?php
                            if (existeNota($alumno['id'], $id_materia, $conn) > 0) {
                                $notas = $conn->prepare("SELECT id, nota FROM notas WHERE id_alumno = " . $alumno['id'] . " AND id_materia = " . $id_materia);
                                $notas->execute();
                                $registrosnotas = $notas->fetchAll();
                                foreach ($registrosnotas as $eval => $nota) {
                                    echo '<input type="hidden" value="' . $nota['id'] . '" name="idnota' . $eval . 'alumno' . $index . '">';
                                    echo '<td><input type="text" maxlength="5" value="' . $nota['nota'] . '" name="evaluacion' . $eval . 'alumno' . $index . '" class="txtnota"></td>';
                                }
                            } else {
                                for ($i = 0; $i < $num_eval; $i++) {
                                    echo '<td><input type="text" maxlength="5" name="evaluacion' . $i . 'alumno' . $index . '" class="txtnota"></td>';
                                }
                            }
                            echo '<td align="center">' . number_format($alumno['promedio'], 2) . '</td>';
                            echo '<td><input type="text" maxlength="100" value="' . $alumno['observaciones'] . '" name="observaciones' . $index . '" class="txtnota"></td>';
                            ?>
                            <td>
                                <form method="post" action="notadelete.php" onsubmit="return confirm('¿Está seguro de que desea eliminar este estudiante?');">
                                    <input type="hidden" name="idalumno" value="<?php echo $alumno['id']; ?>">
                                    <input type="hidden" name="idmateria" value="<?php echo $id_materia; ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
                <button type="submit" name="insertar">Guardar</button> 
                <button type="reset">Limpiar</button> 
                <a class="btn-link" href="listadonotas.view.php">Consultar Notas</a>
                <br>
            </form>
        <?php } ?>
    </div>

</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>