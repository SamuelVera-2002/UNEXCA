<!DOCTYPE html>
<?php
require 'functions.php';
$permisos = ['Administrador', 'Profesor', 'Estudiante'];
permisos($permisos);
?>
<html>
<head>
    <title>Inicio | U.E José Joaquín Veroes</title>
    <meta name="description" content="UNEXCA - matriculación y control de notas" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
        /* Estilos para el modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 80%;
            max-width: 550px;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .close-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .close-btn:hover {
            background-color: #d32f2f;
        }

        footer {
            cursor: pointer; /* Indica que el footer es interactivo */
        }
    </style>
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
            edades comprendidas entre 4 y 6 años</p>
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

<!-- Modal -->
<div id="infoModal" class="modal">
    <div class="modal-content">
        <h2>Información del Proyecto</h2>

        <div style="display: flex; align-items: center; margin-top: 10px;">
            <!-- Imagen pequeña -->
            <img src="./img/Logo_Unexca_Positivo-removebg-preview.png" alt="Logo Universidad" 
            style="width: 90px; height: 60px; margin-right: 10px;">
            <!-- Nombre de la universidad -->
            <span style="font-size: 16px; font-weight: bold;">Universidad Nacional Experimental de Caracas (UNEXCA)</span>
        </div>

        <p><strong>Desarrolladores:</strong></p>

        <ul style="list-style-type: none; padding: 0;">
            <li>Contreras Randal CI: 29.619.452</li>
            <li>Gil Yustin CI: 29.583.353</li>
            <li>Muñoz Sabrina CI: 30.071.075</li>
            <li>Vera Samuel CI: 29.508.501</li>
        </ul>
        <p>Este proyecto fue desarrollado por estudiantes de la UNEXCA como parte del curso de desarrollo de sistemas.</p>
        <button class="close-btn" onclick="closeModal()">Cerrar</button>
    </div>
</div>

<footer onclick="openModal()">
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

<script>
    // Función para mostrar el modal
    function openModal() {
        document.getElementById('infoModal').style.display = 'flex';
    }

    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('infoModal').style.display = 'none';
    }

    // Cierra el modal al hacer clic fuera del contenido
    window.onclick = function(event) {
        const modal = document.getElementById('infoModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
</body>
</html>
