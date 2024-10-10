<?php
// Requiere las librerías FPDF y FPDI
require('fpdf/fpdf.php');
require('fpdi/src/autoload.php');

// Asegúrate de que la carpeta 'uploads' existe.
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if (isset($_POST['signatureData'])) {
    $signatureData = $_POST['signatureData'];

    // Convertir base64 a imagen PNG y guardarla temporalmente
    $signatureImage = base64_decode($signatureData);
    $file = '/var/www/silvia.dipaweb.net/firmas/temp_signature.png';

    if (file_put_contents($file, $signatureImage) === false) {
        die("Error: No se pudo guardar el archivo de la firma.");
    }

    // Validar si el archivo se creó correctamente
    if (!file_exists($file) || filesize($file) == 0) {
        die("Error: El archivo de la firma está vacío o no existe.");
    }
}

// Capturamos los datos enviados desde el formulario
$documentacion = $_POST['documentacion']; // Capturar el valor de la documentación
$dni = $_POST['dni']; // Capturar el valor de número de documento
$letra = utf8_decode($_POST['letra']); // Capturar laletra del documento //Capturar la nacionalidad
$nacionalidad = utf8_decode($_POST['nacionalidad']);
$nombre = utf8_decode($_POST['nombre']);
$apellidos = utf8_decode($_POST['apellidos']);
// Capturar la fecha enviada desde el formulario
$fecha_original = $_POST['fnacimiento']; // Recibe la fecha en formato AAAA-MM-DD
// Convertir la fecha al formato DD/MM/AAAA
$fecha = DateTime::createFromFormat('Y-m-d', $fecha_original);
$fnacimiento = $fecha->format('d/m/Y');
$sexo = $_POST['sexo']; // Capturar el valor del sexo
$tel = $_POST['tel'];
$movil1 = $_POST['movil1'];
$email = $_POST['email'];
$direccion = utf8_decode($_POST['direccion']);
$numero = $_POST['numero'];
$piso = utf8_decode($_POST['piso']);
$codpost = $_POST['codpost'];
$localidad = utf8_decode($_POST['localidad']);
$provincia = utf8_decode($_POST['provincia']);
$minusvalia = isset($_POST['minusvalia']) ? $_POST['minusvalia'] : []; //capturar las opciones seleccionadas (si es que se seleccionaron). Si no se selecciona ninguna opción, asignamos un array vacío.
$titulacion = isset($_POST['titulacion']) ? $_POST['titulacion'] : ''; // Capturamos la titulación seleccionada
$otitulacion = utf8_decode($_POST['otitulacion']);
// Capturamos los datos enviados desde el formulario
$situacion_laboral = $_POST['sit_laboral']; // Capturar el valor de situación laboral
$suspension_demanda = isset($_POST['suspension_demanda']) ? $_POST['suspension_demanda'] : ''; // Capturar el valor de suspensión si se seleccionó desempleado
$lugar_residencia = isset($_POST['lugar_residencia_text']) ? utf8_decode($_POST['lugar_residencia_text']) : '';
$lugar_trabajo = isset($_POST['lugar_trabajo_text']) ? utf8_decode($_POST['lugar_trabajo_text']) : '';
$comoConocido = isset($_POST['comoConocido']) ? utf8_decode($_POST['comoConocido']) : '';
$omedio = isset($_POST['omedio']) ? utf8_decode($_POST['omedio']) : '';
$categoriaProfesional = isset($_POST['categoriaProfesional']) ? $_POST['categoriaProfesional'] : '';
$otrabajo = isset($_POST['otrabajo']) ? utf8_decode($_POST['otrabajo']) : ''; // Para "Otros (especificar)"
$horarioCurso = isset($_POST['horarioCurso']) ? $_POST['horarioCurso'] : '';
$jornadaCurso = isset($_POST['jornadaCurso']) ? $_POST['jornadaCurso'] : '';
$tamanoEmpresa = isset($_POST['tamanoEmpresa']) ? $_POST['tamanoEmpresa'] : '';
$autorizacion = isset($_POST['autorizacion']) ? utf8_decode($_POST['autorizacion']) : '';
$title = isset($_POST['title']) ? utf8_decode($_POST['title']) : 'Título no disponible';
$codigo = isset($_POST['codigo']) ? utf8_decode($_POST['codigo']) : 'Código no disponible';


// Crear el directorio con el nombre del DNI dentro de 'uploads'
$directorio = 'uploads/' . $dni;
if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
}


// Función para ajustar automáticamente el tamaño de la fuente si el texto es largo
function ajustarTextoEnCelda($pdf, $texto, $anchoMax, $alturaCelda) {
    $tamañoFuente = 12; // Tamaño de fuente inicial
    $pdf->SetFont('Arial', '', $tamañoFuente);
    
    // Reducir el tamaño de la fuente si el texto es demasiado largo para la celda
    while ($pdf->GetStringWidth($texto) > $anchoMax) {
        $tamañoFuente--; // Disminuir el tamaño de la fuente
        $pdf->SetFont('Arial', '', $tamañoFuente); // Ajustar el tamaño de la fuente
        if ($tamañoFuente < 8) break; // Límite mínimo del tamaño de fuente (8)
    }
    
    // Imprimir la celda con el tamaño de fuente ajustado
    $pdf->SetLineWidth(0.5);  // Borde más grueso de 0.5 mm
    $pdf->Cell($anchoMax, $alturaCelda, $texto, 0);
}

// Crear una instancia de FPDI
$pdf = new \setasign\Fpdi\Fpdi();

// Ruta del archivo PDF base
$archivo_pdf = 'formulario_base.pdf';

// Agregar la primera página del PDF
$pageCount = $pdf->setSourceFile($archivo_pdf);
$templateId = $pdf->importPage(1);

// Añadir la página del archivo base al nuevo PDF
$pdf->AddPage();
$pdf->useTemplate($templateId, 0, 0, 210); // 210 es el ancho en mm para un A4, ajusta según sea necesario

// Establecer la fuente para los textos que vas a añadir
$pdf->SetFont('Arial', 'B', 12);

// Establecer el grosor del borde de los cuadros de texto (0.3 píxeles)
$pdf->SetLineWidth(0.3);

// Establecer la posición en la que se va a imprimir el texto (en mm desde la esquina superior izquierda)


// Tipo de documentación
// Añadir los cuadros de las opciones del radio button (documentación)
$pdf->SetLineWidth(0.5);  // Borde de 0.5 mm para los cuadros
$pdf->Rect(14, 54.4, 3, 3); // Cuadro opción DNI
$pdf->Rect(31, 54.4, 3, 3); // Cuadro opción Permiso de residencia
$pdf->Rect(59, 54.4, 3, 3); // Cuadro opción Otras autorizaciones
// Marcar la opción seleccionada con una "X"
if ($documentacion == 'DNI') {
    $pdf->SetXY(13.2, 54.7);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción DNI
} elseif ($documentacion == 'Permiso de residencia') {
    $pdf->SetXY(30.2, 54.7);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Permiso de residencia
} elseif ($documentacion == 'Otras autorizaciones administrativas') {
    $pdf->SetXY(58.2, 54.7);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Otras autorizaciones
}

// Nombre del curso
$pdf->SetXY(28, 42);
ajustarTextoEnCelda($pdf, $title, 100, $alturaCelda);
$pdf->Rect(28, 40, 100, 4); // Rectángulo para el título del curso
// Código del curso
$pdf->SetXY(153, 42);
ajustarTextoEnCelda($pdf, $codigo, 14, $alturaCelda);
$pdf->Rect(153, 40, 34, 4); // Rectángulo para el código del curso
// Nº de documento
$pdf->SetXY(84, 59);
ajustarTextoEnCelda($pdf, $dni, 30, $alturaCelda);
$pdf->Rect(84, 57, 30, 4); // Rectángulo para el DNI, largo de 30 mm y alto de 4 mm
//Letra del documento
$pdf->SetXY(128, 59);
ajustarTextoEnCelda($pdf, $letra, 6, $alturaCelda);
$pdf->Rect(128, 57, 6, 4);
// Nacionalidad
$pdf->SetXY(158, 59);
ajustarTextoEnCelda($pdf, $nacionalidad, 38, $alturaCelda);
$pdf->Rect(158, 57, 38, 4);
// Nombre
$pdf->SetXY(142, 68);
$pdf->Rect(142, 66, 54, 4);
ajustarTextoEnCelda($pdf, $nombre, 54, $alturaCelda);
// Apellidos
$pdf->SetXY(32, 68);
$pdf->Rect(32, 66, 90, 4);
ajustarTextoEnCelda($pdf, $apellidos, 90, $alturaCelda);
// Fecha de nacimiento
$pdf->SetXY(32, 76.2); 
ajustarTextoEnCelda($pdf, $fnacimiento, 30, $alturaCelda);
$pdf->Rect(32, 74.2, 30, 4);

// Sexo
// Añadir los cuadros de las opciones del radio button (sexo)
$pdf->SetLineWidth(0.5);  // Borde de 0.5 mm para los cuadros
$pdf->Rect(87, 74.5, 3, 3); // Cuadro opción Mujer
$pdf->Rect(107, 74.5, 3, 3); // Cuadro opción Hombre
if ($sexo == 'mujer') {
    $pdf->SetXY(86.2, 74.7);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Mujer
} elseif ($sexo == 'hombre') {
    $pdf->SetXY(106.2, 74.7);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Hombre
} 
// Teléfono 1
$pdf->SetXY(134, 76.2);
ajustarTextoEnCelda($pdf, $tel, 21, $alturaCelda);
$pdf->Rect(134, 74.2, 21, 4);
// Teléfono 2
$pdf->SetXY(175, 76.2);
ajustarTextoEnCelda($pdf, $movil1, 21, $alturaCelda);
$pdf->Rect(175, 74.2, 21, 4);
// Email
$pdf->SetXY(39.7, 82.8);
ajustarTextoEnCelda($pdf, $email, 62, $alturaCelda);
$pdf->Rect(39.7, 80.8, 62, 4);
// Dirección
$pdf->SetXY(118.4, 82.8);
ajustarTextoEnCelda($pdf, $direccion, 77.6, $alturaCelda);
$pdf->Rect(118.4, 80.8, 77.6, 4);
// Número
$pdf->SetXY(16.8, 90);
ajustarTextoEnCelda($pdf, $numero, 7.8, $alturaCelda);
$pdf->Rect(16.8, 88, 7.8, 4);
// Letra
$pdf->SetXY(32, 90);
ajustarTextoEnCelda($pdf, $piso, 7.8, $alturaCelda);
$pdf->Rect(32, 88, 7.8, 4);
// CP
$pdf->SetXY(46, 90);
ajustarTextoEnCelda($pdf, $codpost, 14, $alturaCelda);
$pdf->Rect(46, 88, 14, 4);
// Localidad
$pdf->SetXY(78, 90);
ajustarTextoEnCelda($pdf, $localidad, 50, $alturaCelda);
$pdf->Rect(78, 88, 50, 4);
// Provincia
$pdf->SetXY(144, 90);
ajustarTextoEnCelda($pdf, $provincia, 52, $alturaCelda);
$pdf->Rect(144, 88, 52, 4);

// Añadir los cuadros de minusvalía en el PDF
$pdf->SetLineWidth(0.5);  // Establecer el grosor del borde de los cuadros
$pdf->Rect(117, 94, 4, 4); // Cuadro opción Física
$pdf->Rect(146, 94, 4, 4); // Cuadro opción Psíquica
$pdf->Rect(172, 94, 4, 4); // Cuadro opción Sensorial

// Marcar las opciones seleccionadas con una "X"
if (in_array('Física', $minusvalia)) {
    $pdf->SetXY(116.4, 94.4);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Física
}

if (in_array('Psíquica', $minusvalia)) {
    $pdf->SetXY(145.4, 94.4);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Psíquica
}

if (in_array('Sensorial', $minusvalia)) {
    $pdf->SetXY(171.4, 94.4);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción Sensorial
}

// Añadir los cuadros de titulación en el PDF
$pdf->SetLineWidth(0.5);  // Establecer el grosor del borde de los cuadros

// Cuadro 1: Sin titulación
$pdf->Rect(18, 109, 4, 4); // Dibujar el cuadro en (X: 50, Y: 150)
if ($titulacion == "Sin titulación") {
    $pdf->SetXY(17.8, 109.3); // Dibujar la "X" en (X: 50.5, Y: 150.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 2: Graduado Escolar/ESO
$pdf->Rect(18, 114, 4, 4); // Dibujar el cuadro en (X: 50, Y: 180)
if ($titulacion == "Graduado Escolar/ESO") {
    $pdf->SetXY(17.8, 114.3); // Dibujar la "X" en (X: 50.5, Y: 180.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 3: Título de Bachiller/BUP/COU/Acc. a mayores de 25 años
$pdf->Rect(18, 119, 4, 4); // Dibujar el cuadro en (X: 50, Y: 170)
if ($titulacion == "Título de Bachiller/BUP/COU/Acc. a mayores de 25 años") {
    $pdf->SetXY(17.8, 119.3); // Dibujar la "X" en (X: 50.5, Y: 170.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 4: Título de Técnico/FP Grado Medio
$pdf->Rect(18, 124, 4, 4); // Dibujar el cuadro en (X: 50, Y: 160)
if ($titulacion == "Título de Técnico/FP Grado Medio") {
    $pdf->SetXY(17.8, 124.3); // Dibujar la "X" en (X: 50.5, Y: 160.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 5: Título de Técnico Superior/FP Superior
$pdf->Rect(18, 129, 4, 4); // Dibujar el cuadro en (X: 50, Y: 190)
if ($titulacion == "Título de Técnico Superior/FP Superior") {
    $pdf->SetXY(17.8, 129.3); // Dibujar la "X" en (X: 50.5, Y: 190.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 6: E. Universitarios 1er ciclo (Diplomatura-Grado-Ingeniería Técnica)
$pdf->Rect(98, 109, 4, 4); // Dibujar el cuadro en (X: 50, Y: 200)
if ($titulacion == "E. Universitarios 1er ciclo (Diplomatura-Grado-Ingeniería Técnica)") {
    $pdf->SetXY(97.4, 109.3); // Dibujar la "X" en (X: 50.5, Y: 200.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 7: E. Universitarios 2do ciclo (Licenciatura-Master-Ingeniería Superior)
$pdf->Rect(98, 114, 4, 4); // Dibujar el cuadro en (X: 50, Y: 230)
if ($titulacion == "E. Universitarios 2do ciclo (Licenciatura-Master-Ingeniería Superior)") {
    $pdf->SetXY(97.4, 114.3); // Dibujar la "X" en (X: 50.5, Y: 230.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 8: E. Universitarios 3er ciclo (Doctor)
$pdf->Rect(98, 119, 4, 4); // Dibujar el cuadro en (X: 50, Y: 220)
if ($titulacion == "E. Universitarios 3er ciclo (Doctor)") {
    $pdf->SetXY(97.4, 119.3); // Dibujar la "X" en (X: 50.5, Y: 220.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 9: Título de Doctorado
$pdf->Rect(98, 124, 4, 4); // Dibujar el cuadro en (X: 50, Y: 210)
if ($titulacion == "Título de Doctorado") {
    $pdf->SetXY(97.4, 124.3); // Dibujar la "X" en (X: 50.5, Y: 210.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 10: Otra titulación
$pdf->Rect(98, 129, 4, 4); // Dibujar el cuadro en (X: 50, Y: 230)
if ($titulacion == "Otra titulación") {
    $pdf->SetXY(97.4, 129.3); // Dibujar la "X" en (X: 50.5, Y: 230.5)
    $pdf->Cell(3, 3, 'X', 0, 0);
    $pdf->SetXY(144, 128); // Cuadro para especificar la titulación
    ajustarTextoEnCelda($pdf, $otitulacion, 53, $alturaCelda);
}

// Añadir los cuadros de las opciones del radio button (situación laboral)
$pdf->SetLineWidth(0.5);  // Borde de 0.5 mm para los cuadros
$pdf->Rect(19, 145, 3, 3); // Cuadro opción desempleado
$pdf->Rect(47, 145, 3, 3); // Cuadro opción trabajador por cuenta propia
$pdf->Rect(139, 145, 3, 3); // Cuadro opción trabajador por cuenta ajena

// Marcar la opción seleccionada con una "X"
if ($sit_laboral == 'Desempleado') {
    $pdf->SetXY(18.3, 145);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción desempleado
} elseif ($sit_laboral == 'Trabajador por cuenta propia') {
    $pdf->SetXY(46.3, 145);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción trabajador por cuenta propia
} elseif ($sit_laboral == 'Trabajador por cuenta ajena') {
    $pdf->SetXY(138.3, 145);
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar opción trabajador por cuenta ajena
}  

// Si se seleccionó "Desempleado", imprimir opciones de "Suspensión de la demanda"
if ($situacion_laboral == 'Desempleado') {
    // Dibujar los cuadros para las opciones de "Suspensión de la demanda"
    $pdf->Rect(19, 154, 3, 3); // Cuadro para "Suspensión de la demanda con intermediación"
    $pdf->Rect(19, 159, 3, 3); // Cuadro para "Suspensión de la demanda sin intermediación"

    // Marcar la opción seleccionada en "Suspensión de la demanda"
    if ($suspension_demanda == 'Suspensión de la demanda con intermediación') {
        $pdf->SetXY(18.3, 154); // Coordenadas para la "X"
        $pdf->Cell(3, 3, 'X', 0, 0); // Marcar "Con intermediación"
    } elseif ($suspension_demanda == 'Suspensión de la demanda sin intermediación') {
        $pdf->SetXY(18.3, 159); // Coordenadas para la "X"
        $pdf->Cell(3, 3, 'X', 0, 0); // Marcar "Sin intermediación"
    }
}

// Dibujar los cuadros para "Lugar de residencia" y "Lugar del centro de trabajo"
$pdf->SetLineWidth(0.3);
$pdf->Rect(19, 166.8, 3, 3); // Cuadro para "Lugar de residencia"
$pdf->Rect(105, 166.8, 3, 3); // Cuadro para "Lugar del centro de trabajo"

// Marcar la opción seleccionada con una "X"
if (!empty($lugar_residencia)) {
    $pdf->SetXY(18.5, 166.8); // Coordenadas para la "X"
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar "Lugar de residencia"
}
if (!empty($lugar_trabajo)) {
    $pdf->SetXY(104.5, 166.8); // Coordenadas para la "X"
    $pdf->Cell(3, 3, 'X', 0, 0); // Marcar "Lugar del centro de trabajo"
}

// Imprimir el lugar de residencia o trabajo
if (!empty($lugar_residencia)) {
    $pdf->SetXY(19, 168);
    $pdf->Cell(0, 10, $lugar_residencia, 0, 1);
}
if (!empty($lugar_trabajo)) {
    $pdf->SetXY(105, 168);
    $pdf->Cell(0, 10, $lugar_trabajo, 0, 1);
}

// Dibujar los cuadros para "¿Cómo conoció la existencia de este curso?"
$pdf->SetLineWidth(0.5);  // Establecer el grosor del borde de los cuadros

// Cuadro 1: Servicio Público Estatal
$pdf->Rect(19, 182, 3, 3); // Posición del cuadro en (X: 19, Y: 182)
if ($comoConocido == 'sepe') {
    $pdf->SetXY(18.3, 182.3); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 2: Itinerario formativo
$pdf->Rect(19, 187.2, 3, 3); // Posición del cuadro en (X: 19, Y: 187.2)
if ($comoConocido == 'itinerario') {
    $pdf->SetXY(18.3, 187.5); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 3: A través de mi empresa
$pdf->Rect(62, 182, 3, 3); // Posición del cuadro en (X: 62, Y: 182)
if ($comoConocido == 'empresa') {
    $pdf->SetXY(61.3, 182.3); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 4: Organización empresarial o sindical
$pdf->Rect(62, 187.2, 3, 3); // Posición del cuadro en (X: 62, Y: 187.2)
if ($comoConocido == 'organizacion') {
    $pdf->SetXY(61.3, 187.5); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 5: Medios de comunicación
$pdf->Rect(121, 182, 3, 3); // Posición del cuadro en (X: 121, Y: 182)
if ($comoConocido == 'medios') {
    $pdf->SetXY(120.3, 182.3); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 6: Otros (especificar)
$pdf->Rect(121, 187.2, 3, 3); // Posición del cuadro en (X: 121, Y: 187.2)
if ($comoConocido == 'otro_medio') {
    $pdf->SetXY(120.3, 187.5); // Marcar "X" dentro del cuadro
    $pdf->Cell(3, 3, 'X', 0, 0);
    if (!empty($omedio)) {
        // Mostrar el texto especificado si el usuario selecciona "Otros"
        $pdf->SetXY(150.5, 186); // Ajustar la posición para el texto
        $pdf->Cell(50, 5, $omedio, 0, 0);
    }
}

// Dibujar los cuadros para "Categoría profesional"
$pdf->SetLineWidth(0.5);  // Establecer el grosor del borde de los cuadros

// Cuadro 1: Directivo
$pdf->Rect(19, 203, 3, 3);
if ($categoriaProfesional == 'directivo') {
    $pdf->SetXY(18.3, 203.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 2: Mando intermedio
$pdf->Rect(19, 208.5, 3, 3);
if ($categoriaProfesional == 'mIntermedio') {
    $pdf->SetXY(18.3, 208.8);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 3: Técnico
$pdf->Rect(62, 203, 3, 3);
if ($categoriaProfesional == 'tecnico') {
    $pdf->SetXY(61.3, 203.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 4: Trabajador cualificado
$pdf->Rect(62, 208.5, 3, 3);
if ($categoriaProfesional == 'tCualificado') {
    $pdf->SetXY(61.3, 208.8);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 5: Trabajador de baja cualificación
$pdf->Rect(121, 203, 3, 3);
if ($categoriaProfesional == 'tBajaCualificacion') {
    $pdf->SetXY(120.3, 203.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Cuadro 6: Otra categoría (especificar)
$pdf->Rect(121, 208.5, 3, 3);
if ($categoriaProfesional == 'otro_trabajo') {
    $pdf->SetXY(120.3, 208.8);
    $pdf->Cell(3, 3, 'X', 0, 0);
    if (!empty($otrabajo)) {
        $pdf->SetXY(163, 206.2);
        $pdf->Cell(50, 5, $otrabajo, 0, 0);
    }
}

// Dibujar los cuadros para "Horario del curso"
$pdf->Rect(19, 219, 3, 3);
if ($horarioCurso == 'dentro') {
    $pdf->SetXY(18.3, 219.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(19, 224, 3, 3);
if ($horarioCurso == 'fuera') {
    $pdf->SetXY(18.3, 224.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(19, 229, 3, 3);
if ($horarioCurso == 'ambas') {
    $pdf->SetXY(18.3, 229.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Dibujar los cuadros para "Jornada laboral del curso"
$pdf->Rect(121, 219, 3, 3);
if ($jornadaCurso == 'menos del 25%') {
    $pdf->SetXY(120.3, 219.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(121, 224, 3, 3);
if ($jornadaCurso == 'entre 25 y 50%') {
    $pdf->SetXY(120.3, 224.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(121, 229, 3, 3);
if ($jornadaCurso == 'más del 50%') {
    $pdf->SetXY(120.3, 229.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Dibujar los cuadros para "Tamaño de la empresa"
$pdf->Rect(19, 239, 3, 3);
if ($tamanoEmpresa == 'de 1 a 9') {
    $pdf->SetXY(18.3, 239.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(51.3, 239, 3, 3);
if ($tamanoEmpresa == 'de 10 a 49') {
    $pdf->SetXY(50.6, 239.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(87, 239, 3, 3);
if ($tamanoEmpresa == 'de 50 a 99') {
    $pdf->SetXY(86.3, 239.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(123, 239, 3, 3);
if ($tamanoEmpresa == 'de 100 a 250') {
    $pdf->SetXY(122.3, 239.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

$pdf->Rect(162, 239, 3, 3);
if ($tamanoEmpresa == 'mas de 250') {
    $pdf->SetXY(161.3, 239.3);
    $pdf->Cell(3, 3, 'X', 0, 0);
}

// Dibujar los cuadros para las opciones de autorización
$pdf->SetLineWidth(0.5);

// Cuadro 1: Sí
$pdf->Rect(160, 266, 3, 3); // Posición del cuadro para "Sí"
if ($autorizacion == 'si') {
    $pdf->SetXY(160, 266); // Marcar "X" en el cuadro "Sí"
    $pdf->Cell(3, 3, 'X', 0, 0);
}
// Cuadro 2: No
$pdf->Rect(170, 266, 3, 3); // Posición del cuadro para "No"
if ($autorizacion == 'no') {
    $pdf->SetXY(170, 166); // Marcar "X" en el cuadro "No"
    $pdf->Cell(3, 3, 'X', 0, 0);
}


// Obtener la fecha actual
$fechaActual = date('d/m/Y');

// Imprimir la fecha actual en el PDF en las coordenadas corregidas
$pdf->SetXY(170, 245); // Coordenadas ajustadas (X: 175, Y: 245), cerca del borde inferior derecho
$pdf->Cell(30, 10, $fechaActual, 0, 1);

// Insertar la firma en el PDF (coordenadas de ejemplo)
$pdf->Image($file, 100, 240, 100, 30); // Ajusta las coordenadas y el tamaño según lo necesites

// Abrir el PDF en el navegador
//$pdf->Output('I', 'formulario_completado.pdf'); // 'I' abre el PDF en el navegador

// Guardar el nuevo archivo PDF en el directorio creado
$pdf_file = $directorio . '/formulario.pdf';
$pdf->Output('F', $pdf_file); // Usamos 'F' para guardar el archivo en el servidor


// Eliminar el archivo temporal de la firma
if (file_exists($file)) {
    unlink($file); // Borrar la imagen temporal una vez que se haya usado
}

// Redirigir al Paso 3 con las variables necesarias
header("Location: paso3.php?dni=$dni&title=" . urlencode($title) . "&codigo=$codigo");
exit();
?>

<!-- En este punto, ya que PHP no puede abrir una nueva pestaña, te devolveremos a un HTML que maneje la nueva pestaña

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3;url=paso3.php" />
    <title>Redirigiendo...</title>
</head>
<body>
    <p>El formulario se ha completado correctamente y el PDF se ha guardado. Serás redirigido a la siguiente página...</p>
    <script>
        // Usamos JavaScript para abrir la nueva pestaña
        window.open('paso3.php', '_blank');
    </script>
</body>
</html> -->