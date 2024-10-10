<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 4 - Subir Documentación</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pasos.css"> 
</head>
<body>
    <?php
    $currentStep = 4; // Paso actual
    include 'includes/progress.php'; // Incluir la barra de progreso

    // Recoger las variables desde la URL
    $dni = isset($_GET['dni']) ? htmlspecialchars($_GET['dni']) : 'DNI no disponible';
    $title = isset($_GET['title']) ? urldecode(htmlspecialchars($_GET['title'])) : 'Título no disponible';
    $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'Código no disponible';
    ?>

   <!-- Contenedor con ancho limitado -->
    <div class="content-wrapper">
        <div class="content text-center">
        <h1>Paso 4: Subir Demanda de Empleo o Vida Laboral</h1>

        <p><strong>Título del curso:</strong> <?php echo $title; ?></p>
        <p><strong>Código del curso:</strong> <?php echo $codigo; ?></p>
        <p><strong>DNI:</strong> <?php echo $dni; ?></p>

        <div class="container mt-5">
            <form action="subir_documento.php" method="POST" enctype="multipart/form-data">
                <div class="upload-section mb-3">
                    <i class="bi bi-cloud-upload"></i> <!-- Ícono de Bootstrap -->
                    <label for="documento" class="form-label" style="color: #4CAF50;">Subir Demanda de Empleo o Vida Laboral: </label>
                    <input type="file" class="form-control" id="documento" name="documento" accept="application/pdf" required>
                    </div>

                <!-- Enviar el DNI y otras variables al script de subida -->
                <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
                <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                <div class="mb-3" style="padding-top: 20px;">
                    <button type="submit" class="btn-siguiente">Subir documento e ir al Paso 5</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
