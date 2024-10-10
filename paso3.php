<!php // Recoger las variables desde la URL
    $dni = isset($_GET['dni']) ? htmlspecialchars($_GET['dni']) : 'DNI no disponible';
    $title = isset($_GET['title']) ? urldecode(htmlspecialchars($_GET['title'])) : 'Título no disponible';
    $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'Código no disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 3 - Subir DNI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
     <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pasos.css"> 
</head>
<body>
    <?php
    $currentStep = 3; // Paso actual
    include 'includes/progress.php'; // Incluir la barra de progreso
    ?>
     <!-- Contenedor con ancho limitado -->
    <div class="content-wrapper">
        <div class="content text-center">
            <h1>Paso 3: Subir las dos caras del DNI</h1>

            <p><strong>Título del curso:</strong> <?php echo $title; ?></p>
            <p><strong>Código del curso:</strong> <?php echo $codigo; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <div class="container mt-5">
                <form action="subir_dni.php" method="POST" enctype="multipart/form-data">
                    <!-- Subir la cara frontal del DNI -->
                    <div class="upload-section mb-3">
                        <i class="bi bi-cloud-upload"></i> <!-- Ícono de Bootstrap -->
                        <label for="dni_frontal" class="form-label">Subir cara frontal del DNI</label>
                        <input type="file" class="form-control" id="dni_frontal" name="dni_frontal" accept="image/*" required>
                    </div>

                    <!-- Subir la cara trasera del DNI -->
                    <div class="upload-section mb-3">
                        <i class="bi bi-cloud-upload"></i>
                        <label for="dni_reverso" class="form-label">Subir cara trasera del DNI</label>
                        <input type="file" class="form-control" id="dni_reverso" name="dni_reverso" accept="image/*" required>
                    </div>

                    <!-- Enviar las variables del formulario -->
                    <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">

                    <!-- Botón de continuar centrado -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-siguiente">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluir iconos de Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css" rel="stylesheet">
</body>
</html>
