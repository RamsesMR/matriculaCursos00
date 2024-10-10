<?php
// Recoger las variables del formulario
$dni = $_POST['dni'];
$title = $_POST['title'];
$codigo = $_POST['codigo'];

// Definir el directorio de subida
$directorio = 'uploads/' . $dni;

// Validar y subir el archivo (Demanda de empleo o Vida laboral)
if (isset($_FILES['documento'])) {
    $documento = $_FILES['documento'];

    // Verificar que el archivo no supere los 5MB
    if ($documento['size'] > 5242880) { // 5MB = 5 * 1024 * 1024 bytes
        die("El archivo es demasiado grande. Tamaño máximo permitido es 5MB.");
    }

    // Verificar que el archivo sea un PDF
    $tipo = mime_content_type($documento['tmp_name']);
    if ($tipo !== 'application/pdf') {
        die("El archivo debe ser un PDF.");
    }

    // Mover el archivo al directorio correcto
    $ruta_documento = $directorio . '/documento_demanda_o_vida_laboral.pdf';
    move_uploaded_file($documento['tmp_name'], $ruta_documento);
}

// Redirigir al paso 5
header("Location: paso5.php?dni=$dni&title=" . urlencode($title) . "&codigo=$codigo");
exit();
?>
