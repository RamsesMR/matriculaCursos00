<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
require 'libs/PHPMailer/src/Exception.php';

// Comprobar si se recibieron los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = isset($_POST['dni']) ? htmlspecialchars($_POST['dni']) : 'DNI no disponible';
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : 'Título no disponible';
    $codigo = isset($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : 'Código no disponible';

    // Dirección de correo a la que se enviarán los datos
    $to = 'silvia.cebrian@campusfp.es';

    // Asunto del correo
    $subject = "Solicitud de Matrícula: $title ($codigo) - DNI: $dni";

    // Mensaje del correo
    $message = "
        <html>
        <head>
            <title>Solicitud de Matrícula</title>
        </head>
        <body>
            <h1>Datos de la Matrícula</h1>
            <p><strong>Título del curso:</strong> $title</p>
            <p><strong>Código del curso:</strong> $codigo</p>
            <p><strong>DNI:</strong> $dni</p>
            <p>Se han subido correctamente los archivos requeridos.</p>
        </body>
        </html>
    ";

    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.ionos.es'; // Cambia por tu servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'web@cursos00.com'; // Tu usuario SMTP
        $mail->Password   = 'W3bCursos00&2020'; // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilitar SSL (en lugar de TLS)
        $mail->Port       = 465;  // Puerto TCP para SSL (465)

        // Configurar el charset a UTF-8
        $mail->CharSet = 'UTF-8';  // IMPORTANTE para caracteres especiales

        // Destinatarios
        $mail->setFrom('no-reply@cursos00.com', 'Cursos00');
        $mail->addAddress($to);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        // Añadir archivos adjuntos
        $directorio = 'uploads/' . $dni;
        $archivos = [
            'Formulario PDF' => $directorio . '/formulario',
            'DNI Frontal' => $directorio . '/dni_frontal',
            'DNI Reverso' => $directorio . '/dni_reverso',
            'Demanda de empleo o Vida laboral' => $directorio . '/documento_demanda_o_vida_laboral'
        ];

        // Buscar archivos con cualquier extensión y adjuntarlos
        foreach ($archivos as $nombre_archivo => $ruta_archivo) {
            $archivos_encontrados = glob($ruta_archivo . '.*');
            if (!empty($archivos_encontrados)) {
                foreach ($archivos_encontrados as $archivo) {
                    $mail->addAttachment($archivo); // Adjuntar archivo
                }
            }
        }

        // Enviar el correo
        if ($mail->send()) {
            echo "<div style='text-align:center; margin-top: 50px;'>
                    <h2>¡Matrícula enviada con éxito!</h2>
                    <p>Tu solicitud de matrícula ha sido enviada correctamente.</p>
                    <a href='index.php' class='btn btn-success'>Volver al inicio</a>
                  </div>";
        } else {
            echo "<div style='text-align:center; margin-top: 50px;'>
                    <h2>Error al enviar la matrícula</h2>
                    <p>Ocurrió un error al enviar tu solicitud de matrícula. Por favor, inténtalo de nuevo más tarde.</p>
                    <a href='index.php' class='btn btn-danger'>Volver al inicio</a>
                  </div>";
        }
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}";
    }
} else {
    header('Location: index.php');
    exit();
}
?>

