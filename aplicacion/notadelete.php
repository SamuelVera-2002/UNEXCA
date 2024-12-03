<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alumno = $_POST['idalumno'];
    $id_materia = $_POST['idmateria'];

    try {
        // Eliminar las notas del estudiante
        $conn->prepare("DELETE FROM notas WHERE id_alumno = ? AND id_materia = ?")->execute([$id_alumno, $id_materia]);
        
        // Eliminar al estudiante
        $conn->prepare("DELETE FROM alumnos WHERE id = ?")->execute([$id_alumno]);

        header("Location: notas.view.php?info=Eliminado");
    } catch (Exception $e) {
        header("Location: notas.view.php?err=NoEliminado");
    }
}