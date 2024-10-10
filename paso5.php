<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 5 - Comprobar archivos</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/pasos.css">
</head>
<body>
    <?php 
    $currentStep = 5; // Paso actual
    include 'includes/progress.php'; // Incluir la barra de progreso
    
    // Recoger las variables desde la URL
    $dni = isset($_GET['dni']) ? htmlspecialchars($_GET['dni']) : 'DNI no disponible';
    $title = isset($_GET['title']) ? urldecode(htmlspecialchars($_GET['title'])) : 'Título no disponible';
    $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'Código no disponible';

    // Definir el directorio donde se almacenan los archivos
    $directorio = 'uploads/' . $dni;

    // Comprobar si los archivos existen en la carpeta
    $archivos = [
        'Formulario PDF' => ['path' => $directorio . '/formulario', 'paso' => 'Paso 2'], // Sin extensión
        'DNI Frontal' => ['path' => $directorio . '/dni_frontal', 'paso' => 'Paso 3'],  // Sin extensión
        'DNI Reverso' => ['path' => $directorio . '/dni_reverso', 'paso' => 'Paso 3'],  // Sin extensión
        'Demanda de empleo o Vida laboral' => ['path' => $directorio . '/documento_demanda_o_vida_laboral', 'paso' => 'Paso 4']  // Sin extensión
    ];

    // Función para comprobar la existencia de archivos sin importar la extensión
    function comprobar_archivo_sin_extension($ruta_base) {
        // Usar glob() para buscar cualquier archivo con ese nombre base y cualquier extensión
        $archivos_encontrados = glob($ruta_base . '.*'); // Busca archivos con cualquier extensión
        // Si se encuentra al menos un archivo que coincida, devolvemos true
        return !empty($archivos_encontrados);
    }

    // Verificar si falta algún archivo
    $archivos_faltantes = [];
    foreach ($archivos as $nombre_archivo => $info) {
        if (!comprobar_archivo_sin_extension($info['path'])) {
            $archivos_faltantes[] = $nombre_archivo . ' (' . $info['paso'] . ')';
        }
    }

    $todos_archivos_presentes = empty($archivos_faltantes);
    ?>

<div class="container text-center">
    <div class="content">
        <h1>Paso 5: Comprobar Archivos Subidos</h1>
        <p><strong>Título del curso:</strong> <?php echo $title; ?></p>
        <p><strong>Código del curso:</strong> <?php echo $codigo; ?></p>
        <p><strong>DNI:</strong> <?php echo $dni; ?></p>

        <!-- Tabla para mostrar el estado de los archivos -->
        <div class="table-container">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archivos as $nombre_archivo => $info): ?>
                    <tr>
                        <td><?php echo $nombre_archivo; ?></td>
                        <td>
                            <?php if (comprobar_archivo_sin_extension($info['path'])): ?>
                                <span class="status-icon status-v">✔️</span> <!-- Archivo presente -->
                            <?php else: ?>
                                <span class="status-icon status-x">❌</span> <!-- Archivo no presente -->
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Mostrar botón o mensaje según el estado de los archivos -->
        <?php if ($todos_archivos_presentes): ?>
            <form action="enviar_matricula.php" method="POST">
                <!-- Enviar las variables al script de matriculación -->
                <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
                <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                <!-- Botón de enviar todo y matricularse -->
                <button type="submit" class="btn btn-matricularse">Enviar todo y matricularse</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger mt-4">
                <br><strong style="color: red;">Faltan los siguientes archivos:</strong>
                <?php foreach ($archivos_faltantes as $archivo): ?>
                    <p><?php echo $archivo; ?></p>
                <?php endforeach; ?>
                <p>Por favor, regresa al paso correspondiente para completar la subida de los archivos faltantes.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
