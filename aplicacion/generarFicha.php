<?php
require 'functions.php';
require 'lib/fpdf/fpdf.php';

// Obtén el ID del alumno
$idAlumno = $_GET['id'];

// Consulta los datos del alumno y representante
$stmt = $conn->prepare("
    SELECT a.nombres, a.apellidos, a.genero, b.nombre as grado, c.nombre as seccion, 
           r.nombre as representante_nombre, r.telefono, r.correo
    FROM alumnos as a 
    INNER JOIN grados as b ON a.id_grado = b.id 
    INNER JOIN secciones as c ON a.id_seccion = c.id
    INNER JOIN representantes as r ON a.id_representante = r.id
    WHERE a.id = :id
");
$stmt->bindParam(':id', $idAlumno);
$stmt->execute();
$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$alumno) {
    die("Alumno no encontrado");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(0, 10, 'Ficha Técnica del Estudiante', 0, 1, 'C');

// Datos del Estudiante
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Datos del Estudiante:', 0, 1);
$pdf->Cell(0, 10, 'Nombres: ' . $alumno['nombres'], 0, 1);
$pdf->Cell(0, 10, 'Apellidos: ' . $alumno['apellidos'], 0, 1);
$pdf->Cell(0, 10, 'Género: ' . $alumno['genero'], 0, 1);
$pdf->Cell(0, 10, 'Grado: ' . $alumno['grado'], 0, 1);
$pdf->Cell(0, 10, 'Sección: ' . $alumno['seccion'], 0, 1);

// Espacio
$pdf->Ln(10);

// Datos del Representante
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Datos del Representante:', 0, 1);
$pdf->Cell(0, 10, 'Nombre: ' . $alumno['representante_nombre'], 0, 1);
$pdf->Cell(0, 10, 'Teléfono: ' . $alumno['telefono'], 0, 1);
$pdf->Cell(0, 10, 'Correo: ' . $alumno['correo'], 0, 1);

// Salida del PDF
$pdf->Output('I', 'Ficha_' . $alumno['nombres'] . '_' . $alumno['apellidos'] . '.pdf');
?>
