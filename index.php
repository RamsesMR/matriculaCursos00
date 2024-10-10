<?php
    // Recoger las variables 'codigo' y 'title' desde la URL.
    $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'Código no disponible';
    $title = isset($_GET['title']) ? urldecode(htmlspecialchars($_GET['title'])) : 'Título no disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 1 - Matriculación</title>
    <!-- Cargar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/pasos.css">
</head>
<body>
        <!-- Progreso fuera del container -->
    <?php
        $currentStep = 1; // Paso actual
        include 'includes/progress.php'; // Incluir la barra de progreso
    ?>

    <!-- Contenedor principal para el contenido -->
    <div class="container">
        <div class="content text-center">
            <h1>Paso 1: Documentación necesaria</h1>

            <!-- Mostrar el título y el código -->
            <h2>Vas a matricularte en el siguiente curso:</h2>
            <p><strong>Título del curso:</strong> <?php echo $title; ?></p>
            <p><strong>Código del curso:</strong> <?php echo $codigo; ?></p>

            <!-- Listado de documentación en dos columnas usando Bootstrap -->
            <div class="row g-3 justify-content-center">
                <p>Antes de continuar, asegúrate de tener preparada la documentación que vas a necesitar según tu situación laboral.</p>
                
                <!-- Columna 1: Documentos para desempleados -->
                <div class="col-md-4 me-md-3" style="border: 2px solid #fab31c; border-radius: 10px; padding: 15px;">
                    <h3>Documentación para Desempleados</h3>
                    <p>DNI / NIE por ambas caras</p>
                    <p>Demanda de empleo actualizada del SEPE (DARDE)</p>
                </div>

                <!-- Columna 2: Documentos para trabajadores en activo -->
                <div class="col-md-4" style="border: 2px solid #fab31c; border-radius: 10px; padding: 15px;">
                    <h3>Documentación para Trabajadores en Activo</h3>
                    <p>DNI / NIE por ambas caras</p>
                    <p>Vida laboral actualizada</p>
                </div>
            </div>

            <div class="row g-3 justify-content-center">
                <div class="col-md-10 me-md-3"></div>
                <div class="col-md-2 me-md-3">
                    <form action="paso2.php" method="GET">
                        <!-- Campos ocultos para enviar las variables title y codigo al paso 2 -->
                        <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">

                        <!-- Botón de continuar -->
                        <button type="submit" class="btn-siguiente">Continuar al Paso 2</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
