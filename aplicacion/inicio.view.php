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
    <div class="text-content">
        <h1>Centro de Educación Inicial - José Joaquín Veroes</h1>
        <h3>Usuario: <?php echo $_SESSION["username"] ?></h3>
    </div>
    <img src="./img/Logo JJV-Photoroom.png" alt="Logo" class="logo">
</div>
<nav class="sidebar">
        <a href="inicio.view.php" class="active"><i></i>Inicio</a>
        <a href="alumnos.view.php"><i></i>Registro de Estudiantes</a>
        <a href="listadoalumnos.view.php"><i></i>Listado de Estudiantes</a>
        <a href="notas.view.php"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">

    <div class="container">
        <div class="left-section">
            <p>Centro de Educación Inicial  <br>
            <strong>"José Joaquín Veroes"</strong><br><br>
            Educación Integral para niños y niñas en <br>
            edades comprendidas entre 2 y 6 años</p>
        </div>
        <div class="right-section">
            <div>
                <h2>¡Le damos la Bienvenida a la Navidad!</h2>
                <div class="video-container">
                    <iframe src="./img/navidad.mp4" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>


</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>