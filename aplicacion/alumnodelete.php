<?php
require 'functions.php';

if ($_SESSION['rol'] == 'Administrador') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        try {
            $id_alumno = $_GET['id'];
            $alumno = $conn->prepare("UPDATE alumnos SET estado_elimination = 'eliminado' WHERE id = :id");
            $alumno->bindParam(':id', $id_alumno, PDO::PARAM_INT);
            $alumno->execute();
            header('location:listadoalumnos.view.php?success=1');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        die('Ha ocurrido un error');
    }
} else {
    /* header('location:inicio.view.php?err=1'); */
}
?>
