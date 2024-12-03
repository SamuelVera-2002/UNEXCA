<!DOCTYPE html>
<?php
require 'functions.php';
$permisos = ['Administrador','Profesor'];
permisos($permisos);
if(isset($_GET['id'])) {

    $id_alumno = $_GET['id'];

    $alumno = $conn->prepare("select * from alumnos where id = ".$id_alumno);
    $alumno->execute();
    $alumno = $alumno->fetch();

//consulta las secciones
    $secciones = $conn->prepare("select * from secciones");
    $secciones->execute();
    $secciones = $secciones->fetchAll();

//consulta de grados
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();

}else{
    Die('Ha ocurrido un error');
}
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
        <a href="inicio.view.php" ><i></i>Inicio</a>
        <a href="alumnos.view.php"><i></i>Registro de Estudiantes</a>
        <a href="listadoalumnos.view.php" class="active"><i></i>Listado de Estudiantes</a>
        <a href="notas.view.php"><i></i>Registro de Notas</a>
        <a href="listadonotas.view.php"><i></i>Consulta de Notas</a>
        <a href="logout.php"><i></i>Salir</a>
</nav>

<div class="body">
    <div class="panel">
            <h1>Editar datos de un estudiante</h1>
            <form method="post" class="form" action="procesaralumno.php">
                <!--colocamos un campo oculto que tiene el id del alumno-->
                <input type="hidden" value="<?php echo $alumno['id']?>" name="id">
                <label>Nombres</label><br>
                <input type="text" required name="nombres" value="<?php echo $alumno['nombres']?>" maxlength="45">
                <br><br>
                <label>Apellidos</label><br>
                <input type="text" required name="apellidos" value="<?php echo $alumno['apellidos']?>" maxlength="45">
                <br><br>
                <label>Sexo</label><br><input required type="radio" name="genero" <?php if($alumno['genero'] == 'M'){ echo "checked";} ?> value="M"> Masculino
                <input type="radio" name="genero" required value="F" <?php if($alumno['genero'] == 'F') { echo "checked";} ?>> Femenino
                <br><br>
                <label>Grado</label><br>
                <select name="grado" required>
                    <?php foreach ($grados as $grado):?>
                        <option value="<?php echo $grado['id'] ?>" <?php if($alumno['id_grado'] == $grado['id']) { echo "selected";} ?> ><?php echo $grado['nombre'] ?></option>
                    <?php endforeach;?>
                </select>
                <br><br>
                <label>Sección</label><br>

                    <?php foreach ($secciones as $seccion):?>
                        <input type="radio" name="seccion" <?php if($alumno['id_seccion'] == $seccion['id']) { echo "checked";} ?> required value="<?php echo $seccion['id'] ?>">Seccion <?php echo $seccion['nombre'] ?>
                    <?php endforeach;?>

                <br><br>
                <button type="submit" name="modificar">Guardar Cambios</button> <a class="btn-link" href="listadoalumnos.view.php">Ver Listado</a>
                <br><br>
                <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                <?php
                if(isset($_GET['err']))
                    echo '<span class="error">Error al editar el registro</span>';
                if(isset($_GET['info']))
                    echo '<span class="success">Registro modificado correctamente!</span>';
                ?>

            </form>
        </div>
</div>

<footer>
    <p>UNEXCA - Derechos reservados &copy; 2024</p>
</footer>

</body>

</html>