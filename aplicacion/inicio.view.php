<!DOCTYPE html>
<?php
require 'functions.php';
$permisos = ['Administrador','Profesor','Estudiante'];
permisos($permisos);

?>
<html>
<head>
<title>Inicio | U.E José Joaquín Veroes</title>
    <meta name="description" content="UNEXCA - matriculación y control de notas" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>
<div class="header">
        <h1>U.E José Joaquín Veroes</h1>
        <h3>Usuario:  <?php echo $_SESSION["username"] ?></h3>
</div>
<nav>
    <ul>
        <li class="active"><a href="inicio.view.php">Inicio</a> </li>
        <li><a href="alumnos.view.php">Registro de Estudiantes</a> </li>
        <li><a href="listadoalumnos.view.php">Listado de Estudiantes</a> </li>
        <li><a href="notas.view.php">Registro de Notas</a> </li>
        <li><a href="listadonotas.view.php">Consulta de Notas</a> </li>
        <li class="right"><a href="logout.php">Salir</a> </li>

    </ul>
</nav>

<div class="body">
    <div class="panel">
           <h1 class="text-center">Desarrollo de sistema informático para matriculación y control de notas<br>U.E José Joaquín Veroes</h1>
        <?php
        if(isset($_GET['err'])){
            echo '<h3 class="error text-center">ERROR: Usuario no autorizado</h3>';
        }
        ?>
        <br>
        <hr>
        <p class="text-center"><strong>Integrantes</strong><br><br>
        Randal Contreras<br>Yustin Gil<br>Sabrina Muñoz<br>Samuel Vera</p>
        <br>
        </div>
</div>

<footer>

    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>