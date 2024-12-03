<?php
require 'functions.php';

$permisos = ['Administrador', 'Profesor'];
permisos($permisos);

// Consulta los alumnos para el listado de alumnos excluyendo los eliminados
$alumnos = $conn->prepare("SELECT a.id, a.num_lista, a.nombres, a.apellidos, a.genero, b.nombre as grado, c.nombre as seccion FROM alumnos as a INNER JOIN grados as b ON a.id_grado = b.id INNER JOIN secciones as c ON a.id_seccion = c.id WHERE a.estado_elimination = 'activo' ORDER BY a.apellidos");
$alumnos->execute();
$alumnos = $alumnos->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Listado de Estudiantes | Registro de Notas</title>
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
        <a href="listadoalumnos.view.php" class="active"><i></i>Listado de Estudiantes</a>
        <a href="notas.view.php"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">
        <div class="panel">
            <h1>Mátricula escolar completa</h1>
            <?php
            // Mostrar mensaje de éxito si existe
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo '<script>alert("El estudiante se ha eliminado correctamente");</script>';
            }
            ?>
                <table class="table" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Nº de<br>lista</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Género</th>
                        <th>Grado</th>
                        <th>Sección</th>
                        <th>Ficha<br>Técnica</th> <!-- Nueva columna -->
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php 
                    $num_lista = 1; // Inicializar contador de la lista
                    foreach ($alumnos as $alumno) : ?>
                    <tr>
                        <td align="center"><?php echo $num_lista++; ?></td>
                        <td><?php echo $alumno['apellidos']; ?></td>
                        <td><?php echo $alumno['nombres']; ?></td>
                        <td align="center"><?php echo $alumno['genero']; ?></td>
                        <td align="center"><?php echo $alumno['grado']; ?></td>
                        <td align="center"><?php echo $alumno['seccion']; ?></td>
                        <td align="center">
                            <a href="./files/pdf-ejemplo.pdf" target="_blank">Ver</a> <!-- Link para generar PDF -->
                        </td>
                        <td><a href="alumnoedit.view.php?id=<?php echo $alumno['id']; ?>">Editar</a></td>
                        <td><a href="alumnodelete.php?id=<?php echo $alumno['id']; ?>">Eliminar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <br><br>
            <a class="btn-link" href="alumnos.view.php">Agregar estudiante</a>
            <br><br>
            <!--mostrando los mensajes que recibe a través de los parámetros en la URL-->
            <?php
            if (isset($_GET['err']))
                echo '<span class="error">Error al almacenar el registro</span>';
            ?>
        </div>
</div>
<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

<script>
    // JavaScript para mostrar y ocultar el mensaje popup
    document.addEventListener('DOMContentLoaded', function () {
        var popup = document.getElementById('popup');
        if (popup) {
            popup.style.display = 'block';
        }
    });

    setTimeout(function () {
        var popup = document.getElementById('popup');
        if (popup) {
            popup.style.display = 'none';
        }
    }, 7000); // Mostrar durante 2 segundos, luego ocultar
</script>


</body>
</html>
