<?php
//arreglo con mensajes que puede recibir
$messages = [
    "1" => "Credenciales incorrectas",
    "2" => "No ha iniciado sesión"
];
?>
<!DOCTYPE html>
<html>
<head>
<title>Login | U.E José Joaquín Veroes</title>
    <meta name="description" content="matriculación y control de notas" />
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

<div class="header1" >
    <h1>U.E José Joaquín Veroes - Matriculación y control de notas</h1>
</div>

<div class="body1">
    
    <div class="panel-login">
            <h4>Inicio de Sesión</h4>
            <form method="post" class="form" action="login_post.php">
                <label>Usuario</label><br>
                <input type="text" name="username">
                <br>
                <label>Contraseña</label><br>
                <input type="password" name="password">
                <br><br>
                <button type="submit" >Entrar</button>
            </form>
        <?php
        if(isset($_GET['err']) && is_numeric($_GET['err']) && $_GET['err'] > 0 && $_GET['err'] < 3 )
            echo '<span class="error">'.$messages[$_GET['err']].'</span>';
        ?>
        </div>
</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>