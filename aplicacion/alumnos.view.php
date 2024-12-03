<!DOCTYPE html>
<?php
require 'functions.php';
//Define queienes tienen permiso en este archivo
$permisos = ['Administrador','Profesor'];
permisos($permisos);
//consulta las secciones
$secciones = $conn->prepare("select * from secciones");
$secciones->execute();
$secciones = $secciones->fetchAll();

//consulta de grados
$grados = $conn->prepare("select * from grados");
$grados->execute();
$grados = $grados->fetchAll();
?>
<html>
<head>
<title>Registro de estudiantes</title>
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
        <a href="alumnos.view.php" class="active"><i></i>Registro de Estudiantes</a>
        <a href="listadoalumnos.view.php"><i></i>Listado de Estudiantes</a>
        <a href="notas.view.php"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">
    <div class="panel">
            <h1>Registro de Estudiantes</h1>
            <form method="post" class="form" action="procesaralumno.php">
                <label>Nombres</label><br>
                <input type="text" required name="nombres" maxlength="20">
                <br>
                <label>Apellidos</label><br>
                <input type="text" required name="apellidos" maxlength="20">
                <br><br>
                <!--<label>N° de Lista</label><br>
                <input type="number" min="1" class="number" name="numlista">
                <br><br>-->
                <label>Sexo</label><br><input required type="radio" name="genero" value="M"> Masculino
                <input type="radio" name="genero" required value="F"> Femenino
                <br><br>
                <label>Grado</label><br>
                <select name="grado" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>"><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br><br>
                <label>Sección</label><br>

                    <?php foreach ($secciones as $seccion):?>
                        <input type="radio" name="seccion" required value="<?php echo $seccion['id'] ?>">Sección <?php echo $seccion['nombre'] ?>
                    <?php endforeach;?>

                <br><br>
                <button type="submit" name="insertar">Guardar</button> <button type="reset">Limpiar</button> <a class="btn-link" href="listadoalumnos.view.php">Ver Listado</a>
                <br><br>
                <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al almacenar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                ?>

            </form>
        <?php
        if(isset($_GET['err']))
            echo '<span class="error">Error al guardar</span>';
        ?>
        </div>
</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>