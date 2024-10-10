<?php
        // Recoger las variables 'codigo' y 'title' desde la URL.
        $codigo = isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : 'Código no disponible';
        $title = isset($_GET['title']) ? urldecode(htmlspecialchars($_GET['title'])) : 'Título no disponible';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- optimiza la visualización en dispositivos móviles, estableciendo un ancho de visualización igual al del dispositivo-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 2 - Formulario PDF</title>
     <!-- Cargar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir jSignature -->
    <script src="https://cdn.jsdelivr.net/npm/jsignature@2.1.2/libs/jSignature.min.js"></script>
    <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/pasos.css"> 
</head>
<body>
    <?php
    $currentStep = 2; // Paso actual
    include 'includes/progress.php'; // Incluir la barra de progreso
    ?>
   
    <div class="container-fluid mt-5">
        <!-- Centralizamos todo el contenido -->
        <div class="row justify-content-center">
            <div class="col-md-8 mx-auto">
                <!-- Esta sección estará centrada -->
                <div class="text-center">
                    <h1>Paso 2: Formulario de matrícula online</h1>
                    <h2>Vas a matricularte en el siguiente curso:</h2>
                    <p><strong>Título del curso:</strong> <?php echo $title; ?></p>
                    <p><strong>Código del curso:</strong> <?php echo $codigo; ?></p>
                </div>

                <!-- El formulario estará alineado a la izquierda -->
                <form id="formulario" action="generate_pdf.php" method="POST" onsubmit="return captureSignature()" novalidate class="text-start">
                
                <!-- Sección para datos personales -->
                <h2 class="section-title">Datos personales</h2>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Tipo de Documento -->
                        <label class="form-label">Tipo de documentación <span class="asterisk">*</span></label>
                        <div class="col-md-12 mb-3 mb-md-0">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"  name="documentacion" id="DNI" value="DNI" required>
                                <label class="form-check-label" for="DNI">
                                    DNI
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="documentacion" id="permiso_residencia" value="permiso_residencia" required>
                                <label class="form-check-label" for="permiso_residencia">
                                    Permiso de residencia
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="documentacion" id="otras_autorizaciones" value="otras_autorizaciones" required>
                                <label class="form-check-label" for="otras_autorizaciones">
                                    Otras autorizaciones administrativas
                                </label>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Número de Documento -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="dni" class="form-label">Número de Documento <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" maxlength="9" id="dni" name="dni" placeholder="Introduce el número" required>
                            <span class="error-mensaje" id="error-dni"></span>
                            <div class="invalid-feedback">
                          
                                Por favor, introduce un número de documento válido.
                            </div>
                        </div>
                        <!-- Campo de Letra de Documento -->
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label for="letra" class="form-label">Letra <span class="asterisk">*</span></label>
                            <input type="text" class="form-control"  maxlength="1" id="letra" name="letra" placeholder="Letra" required>
                            <span class="error-mensaje" id="error-letra"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce una letra válida.
                            </div>
                        </div>
                        <!-- Campo de Nacionalidad -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="nacionalidad" class="form-label">Nacionalidad <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad" required>
                            <span class="error-mensaje" id="error-nacionalidad"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce una nacionalidad válida.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Apellidos -->
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="apellidos" class="form-label">Apellidos <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                            <span class="error-mensaje" id="error-apellido"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce apellidos válidos.
                            </div>
                        </div>
                        <!-- Campo de Nombre -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="nombre" class="form-label">Nombre <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                            <span class="error-mensaje" id="error-nombre"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un nombre válido.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Fecha de nacimiento -->
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label for="fnacimiento" class="form-label">Fecha de nacimiento <span class="asterisk">*</span></label>
                            <input type="date" class="form-control" id="fnacimiento" name="fnacimiento" placeholder="dd/mm/aaaa" required>
                            <div class="invalid-feedback">
                                Por favor, selecciona tu fecha de nacimiento.
                            </div>
                        </div>
                        <!-- Campo de Sexo -->
                        <div class="col-md-2 mb-3 mb-md-0 align-self-center">
                            <label class="form-label">Sexo <span class="asterisk">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" id="mujer" value="mujer" required>
                                    <label class="form-check-label" for="mujer">Mujer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" id="hombre" value="hombre" required>
                                    <label class="form-check-label" for="hombre">Hombre</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                        <!-- Campo de Teléfono 1 -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="tel" class="form-label">Teléfono 1 <span class="asterisk">*</span></label>
                            <input type="tel" class="form-control" id="tel" name="tel" placeholder="+34" maxlength="9" required pattern="[0-9]{9}">
                            <span class="error-mensaje" id="error-tel1"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un número de teléfono válido de 9 dígitos.
                            </div>
                        </div>
                        <!-- Campo de Teléfono 2 -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="movil1" class="form-label">Teléfono2</label>
                            <input type="tel" class="form-control" id="movil1" name="movil1" placeholder="+34" maxlength="9" pattern="[0-9]{9}">
                          
                            <div class="invalid-feedback">
                                Por favor, introduce un número de teléfono válido de 9 dígitos.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Correo Electrónico -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="email" class="form-label">Correo Electrónico <span class="asterisk">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu email" required>
                            <span class="error-mensaje" id="error-email"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un correo válido.
                            </div>
                        </div>
                        <!-- Campo de Dirección -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="nacionalidad" class="form-label">Dirección <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle/Avda./Plaza" required>
                            <span class="error-mensaje" id="error-direccion"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce una dirección válida.
                            </div>
                        </div>
                        <!-- Nº -->
                        <div class="col-md-1 mb-3 mb-md-0">
                            <label for="numero" class="form-label">Nº<span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" required>
                            <span class="error-mensaje" id="error-Ncalle"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un número válido.
                            </div>
                        </div>
                        <!-- Piso -->
                        <div class="col-md-1 mb-3 mb-md-0">
                            <label for="piso" class="form-label">Piso<span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="piso" name="piso" placeholder="Nº" required>
                            <span class="error-mensaje" id="error-Npiso"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un piso válido.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">   
                        <!-- Campo de código postal -->
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label for="codpost" class="form-label">CP <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="codpost" name="codpost" placeholder="CP" maxlength="5" required pattern="[0-9]{5}">
                            <span class="error-mensaje" id="error-cp"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce un código postal de 5 dígitos.
                            </div>
                        </div>
                        <!-- Campo de Población -->
                        <div class="col-md-5 mb-3 mb-md-0">
                            <label for="localidad" class="form-label">Población/Localidad <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Población" required>
                            <span class="error-mensaje" id="error-localidad"></span>
                            <div class="invalid-feedback">
                                Por favor, introduce una población válida.
                            </div>
                            </div>
                        <!-- Campo de Provincia -->
                        <div class="col-md-5 mb-3 mb-md-0">
                            <label for="provincia" class="form-label">Provincia <span class="asterisk">*</span></label>
                            <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" required>
                            <span class="error-mensaje" id="error-provincia"></span>
                            <div class="invalid-feedback">
                                    Por favor, introduce una provincia válida.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                        <!-- Campo de Minusvalía -->
                         <div class="col-md-12 mb-3 mb-md-0">
                            <label class="form-label">¿Posee algún tipo de minusvalía certificada (más del 33%)?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="fisica" name="minusvalia[]" value="Física">
                                <label class="form-check-label" for="fisica">Física</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="psiquica" name="minusvalia[]" value="Psíquica">
                                <label class="form-check-label" for="psiquica">Psíquica</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sensorial" name="minusvalia[]" value="Sensorial">
                                <label class="form-check-label" for="sensorial">Sensorial</label>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                    </div>
                <!-- Sección para datos académicos -->
                <h2 class="section-title">Datos académicos</h2>
                    <!-- Campo titulación actual -->
                    <div class="row mb-2 mb-md-3">
                        <label class="form-label">Titulación actual <span class="asterisk">*</span></label>
                        <!-- Primera columna de opciones -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="sin_titulacion" name="titulacion" value="Sin titulación" required>
                                <label class="form-check-label" for="sin_titulacion">Sin titulación</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="eso" name="titulacion" value="Graduado Escolar/ESO" required>
                                <label class="form-check-label" for="eso">Graduado Escolar/ESO</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="bachiller" name="titulacion" value="Título de Bachiller/BUP/COU/Acc. a mayores de 25 años" required>
                                <label class="form-check-label" for="bachiller">Título de Bachiller/BUP/COU/Acc. a mayores de 25 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="fp_medio" name="titulacion" value="Título de Técnico/FP Grado Medio" required>
                                <label class="form-check-label" for="fp_medio">Título de Técnico/FP Grado Medio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="fp_superior" name="titulacion" value="Título de Técnico Superior/FP Superior" required>
                                <label class="form-check-label" for="fp_superior">Título de Técnico Superior/FP Superior</label>
                            </div>
                        </div>

                        <!-- Segunda columna de opciones -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="universitario_1ciclo" name="titulacion" value="E. Universitarios 1er ciclo (Diplomatura-Grado-Ingeniería Técnica)" required>
                                <label class="form-check-label" for="universitario_1ciclo">E. Universitarios 1er ciclo (Diplomatura-Grado-Ingeniería Técnica)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="universitario_2ciclo" name="titulacion" value="E. Universitarios 2do ciclo (Licenciatura-Master-Ingeniería Superior)" required>
                                <label class="form-check-label" for="universitario_2ciclo">E. Universitarios 2do ciclo (Licenciatura-Master-Ingeniería Superior)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="universitario_3ciclo" name="titulacion" value="E. Universitarios 3er ciclo (Doctor)" required>
                                <label class="form-check-label" for="universitario_3ciclo">E. Universitarios 3er ciclo (Doctor)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="doctorado" name="titulacion" value="Título de Doctorado" required>
                                <label class="form-check-label" for="doctorado">Título de Doctorado</label>
                            </div>
                            <div class="form-check d-inline-flex align-items-center">
                                <input class="form-check-input" type="radio" id="otra_titulacion" name="titulacion" value="Otra titulación">
                                <label class="form-check-label ms-2" for="otra_titulacion">Otra titulación (especificar)</label>
                                <input type="text" class="form-control d-inline-block w-auto ms-2" id="otitulacion" name="otitulacion" placeholder="Especificar titulación">
                            </div>
                        </div>
                    </div>
                <!-- Sección para datos laborales -->
                <h2 class="section-title">Datos laborales</h2>
                    <!-- Campo Situación actual -->
                    <div class="row mb-2 mb-md-3">
                        <label class="form-label">Situación laboral <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="desempleado" name="sit_laboral" value="Desempleado" required>
                                <label class="form-check-label" for="desempleado">Desempleado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="cuenta_propia" name="sit_laboral" value="Trabajador por cuenta propia" required>
                                <label class="form-check-label" for="cuenta_propia">Trabajador por cuenta propia (empresario, autónomo, cooperativista...)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="cuenta_ajena" name="sit_laboral" value="Trabajador por cuenta ajena" required>
                                <label class="form-check-label" for="cuenta_ajena">Trabajador por cuenta ajena (público, privado)</label>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona tu situación laboral.
                            </div>
                        </div>
                    </div>
                    <!-- Opciones adicionales que dependen de "Desempleado" -->
                    <div class="row mb-2 mb-md-3">
                        <div class="row mb-2 mb-md-3">
                            <label class="form-label">Si ha marcado DESEMPLEADO seleccione una de estas dos opciones, que activaremos o no sobre su demanda</label>
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="suspension_intermediacion" name="suspension_demanda" value="Suspensión de la demanda con intermediación" disabled>
                                    <label class="form-check-label" for="suspension_intermediacion">Suspensión de la demanda con intermediación (recibiendo ofertas de empleo durante el desarrollo de la acción formativa)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="suspension_sin_intermediacion" name="suspension_demanda" value="Suspensión de la demanda sin intermediación" disabled>
                                    <label class="form-check-label" for="suspension_sin_intermediacion">Suspensión de la demanda sin intermediación (no recibiendo ofertas de empleo durante el desarrollo de la acción formativa)</label>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor, selecciona una opción si corresponde.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Campo Lugar de residencia/trabajo -->
                    <div class="row mb-2 mb-md-3">
                        <label class="form-label">Lugar de residencia/trabajo (indicar municipio)</label>
                        
                        <!-- Columna para Lugar de residencia -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check_residencia" name="lugar_residencia" disabled>
                                <label class="form-check-label" for="check_residencia">Lugar de residencia</label>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" id="lugar_residencia" name="lugar_residencia_text" placeholder="Indicar lugar de residencia" disabled>
                            </div>
                        </div>
                        
                        <!-- Columna para Lugar del centro de trabajo -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check_trabajo" name="lugar_trabajo" disabled>
                                <label class="form-check-label" for="check_trabajo">Lugar del centro de trabajo</label>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" id="lugar_trabajo" name="lugar_trabajo_text" placeholder="Indicar lugar del centro de trabajo" disabled>
                            </div>
                        </div>
                        
                        <div class="invalid-feedback">
                            Por favor, indica el municipio.
                        </div>
                    </div>
                    <!-- Cómo conocido-->
                    <div class="row mb-2 mb-md-3">
                        <label class="form-label">¿Cómo conoció la existencia de este curso? (indicar solo el medio principal)</label>

                        <!-- Primera columna -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="sepe" name="comoConocido" value="sepe" required>
                                <label class="form-check-label" for="sepe">Servicio Público Estatal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="itinerario" name="comoConocido" value="itinerario">
                                <label class="form-check-label" for="itinerario">Itinerario formativo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="empresa" name="comoConocido" value="empresa">
                                <label class="form-check-label" for="empresa">A través de mi empresa</label>
                            </div>
                        </div>

                        <!-- Segunda columna -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="organizacion" name="comoConocido" value="organizacion">
                                <label class="form-check-label" for="organizacion">Organización empresarial o sindical</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="medios" name="comoConocido" value="medios">
                                <label class="form-check-label" for="medios">Medios de comunicación: prensa, radio, internet...</label>
                            </div>
                            <div class="form-check d-inline-flex align-items-center">
                                <input class="form-check-input" type="radio" id="otro_medio" name="comoConocido" value="otro_medio">
                                <label class="form-check-label ms-2" for="otro_medio">Otros (especificar)</label>
                                <input type="text" class="form-control d-inline-block w-auto ms-2" id="omedio" name="omedio" placeholder="Especificar medio">
                            </div>
                        </div>

                        <div class="invalid-feedback">
                            Por favor, selecciona cómo conociste el curso.
                        </div>
                    </div>
                <!-- Sección para ocupados -->
                <h2 class="section-title">A responder sólo por los participantes ocupados</h2>
                   <div class="row mb-3">
                        <!-- CATEGORÍA PROFESIONAL en dos columnas -->
                        <div class="col-md-6">
                            <label class="form-label">Categoría Profesional:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="directivo" name="categoriaProfesional" value="directivo" disabled>
                                <label class="form-check-label" for="directivo">Directivo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="mIntermedio" name="categoriaProfesional" value="mIntermedio" disabled>
                                <label class="form-check-label" for="mIntermedio">Mando intermedio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="tecnico" name="categoriaProfesional" value="tecnico" disabled>
                                <label class="form-check-label" for="tecnico">Técnico</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="tCualificado" name="categoriaProfesional" value="tCualificado" disabled>
                                <label class="form-check-label" for="tCualificado">Trabajador cualificado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="tBajaCualificacion" name="categoriaProfesional" value="tBajaCualificacion" disabled>
                                <label class="form-check-label" for="tBajaCualificacion">Trabajador de baja cualificación</label>
                            </div>
                            <div class="form-check d-inline-flex align-items-center">
                                <input class="form-check-input" type="radio" id="otro_trabajo" name="categoriaProfesional" value="otro_trabajo" disabled>
                                <label class="form-check-label ms-2 for="otro_trabajo">Otros (especificar)</label>
                                <input type="text" class="form-control d-inline-block w-auto ms-2" id="otrabajo" name="otrabajo" placeholder="Especificar" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- HORARIO DEL CURSO en dos columnas -->
                    <div class="row mb-3">
                        <label class="form-label">Horario del Curso:</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="horario_dentro" name="horarioCurso" value="dentro" disabled>
                                <label class="form-check-label" for="horario_dentro">Dentro de la jornada laboral</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="horario_fuera" name="horarioCurso" value="fuera" disabled>
                                <label class="form-check-label" for="horario_fuera">Fuera de la jornada laboral</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="horario_ambas" name="horarioCurso" value="ambas" disabled>
                                <label class="form-check-label" for="horario_ambas">Ambas</label>
                            </div>
                        </div>
                    </div>

                    <!-- JORNADA LABORAL DEL CURSO en dos columnas -->
                    <div class="row mb-3">
                        <label class="form-label">Jornada laboral que abarca el Curso:</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="menos" name="jornadaCurso" value="menos del 25%" disabled>
                                <label class="form-check-label" for="menos">Menos del 25%</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="entre" name="jornadaCurso" value="entre 25 y 50%" disabled>
                                <label class="form-check-label" for="entre">Entre el 25 y el 50%</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="mas" name="jornadaCurso" value="más del 50%" disabled>
                                <label class="form-check-label" for="mas">Más del 50%</label>
                            </div>
                        </div>
                    </div>

                    <!-- TAMAÑO DE LA EMPRESA en una sola línea -->
                    <div class="row mb-3">
                        <label class="form-label">Tamaño de la empresa del participante:</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="empresa1" name="tamanoEmpresa" value="de 1 a 9" disabled>
                                <label class="form-check-label" for="empresa1">De 1 a 9 empleados</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="empresa2" name="tamanoEmpresa" value="de 10 a 49" disabled>
                                <label class="form-check-label" for="empresa2">De 10 a 49 empleados</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="empresa3" name="tamanoEmpresa" value="de 50 a 99" disabled>
                                <label class="form-check-label" for="empresa3">De 50 a 99 empleados</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="empresa4" name="tamanoEmpresa" value="de 100 a 250" disabled>
                                <label class="form-check-label" for="empresa4">De 100 a 250 empleados</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="empresa5" name="tamanoEmpresa" value="mas de 250" disabled>
                                <label class="form-check-label" for="empresa5">Más de 250 empleados</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mb-md-3">
                   <!-- Campo Autorización -->
                    <div class="col-md-6">
                         <label class="form-label form-check-inline">¿Autoriza a la Administración a consultar su vida laboral? <span class="asterisk">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="autorizacion" id="si" value="si" required>
                                <label class="form-check-label" for="si">
                                    Sí
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="autorizacion" id="no" value="no" required>
                                <label class="form-check-label" for="no">
                                    No
                                </label>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                    </div>

                    <!-- Campos ocultos para enviar las variables title y codigo al paso 2 -->
                        <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">

                    <!-- Campo de firma -->

                    <div class="row mb-3">
                        <label for="signature" class="form-label">Firma:</label>
                             <div class="col-12">
                                <div id="signature" class="signature-container" style="min-height: 150px; border: 1px solid #000;"></div> <!-- Contenedor de la firma -->
                            </div>
                        <div class="col-12 mt-2">
                         <button type="button" onclick="clearSignature()" class="btn btn-danger">Borrar Firma</button>
                        </div>
                    </div>
<input type="hidden" id="signatureData" name="signatureData">
 <!-- Campo oculto para la firma -->

                              <!-- Botón de continuar centrado -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-siguiente">Continuar</button>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Cargar Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar el formulario
    var form = document.getElementById('formulario');

    // Añadir un evento 'submit' al formulario
    form.addEventListener('submit', function (event) {
        // Evitar el envío del formulario si hay campos inválidos
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Añadir la clase de Bootstrap para mostrar los errores
        form.classList.add('was-validated');
    }, false);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const desempleadoRadio = document.getElementById('desempleado');
    const cuentaPropiaRadio = document.getElementById('cuenta_propia');
    const cuentaAjenaRadio = document.getElementById('cuenta_ajena');

    const suspensionIntermediacion = document.getElementById('suspension_intermediacion');
    const suspensionSinIntermediacion = document.getElementById('suspension_sin_intermediacion');

    const checkResidencia = document.getElementById('check_residencia');
    const inputResidencia = document.getElementById('lugar_residencia');
    const checkTrabajo = document.getElementById('check_trabajo');
    const inputTrabajo = document.getElementById('lugar_trabajo');

    // Campos de "Categoría Profesional", "Horario del Curso", "Jornada laboral", "Tamaño de Empresa"
    const categoriaProfesionalRadios = document.querySelectorAll('input[name="categoriaProfesional"]');
    const horarioCursoRadios = document.querySelectorAll('input[name="horarioCurso"]');
    const jornadaCursoRadios = document.querySelectorAll('input[name="jornadaCurso"]');
    const tamanoEmpresaRadios = document.querySelectorAll('input[name="tamanoEmpresa"]');
    const otroTrabajoInput = document.getElementById('otrabajo');

    // Función para habilitar/deshabilitar las opciones de suspensión de la demanda
    function toggleSuspensionOptions(enable) {
        suspensionIntermediacion.disabled = !enable;
        suspensionSinIntermediacion.disabled = !enable;

        // Añadir o quitar el atributo required
        suspensionIntermediacion.required = enable;
        suspensionSinIntermediacion.required = enable;

        // Limpiar selección si están deshabilitados
        if (!enable) {
            suspensionIntermediacion.checked = false;
            suspensionSinIntermediacion.checked = false;
        }
    }

    // Función para activar/desactivar los campos de lugar de residencia/trabajo
    function toggleLugarCampos(enableResidencia, enableTrabajo) {
        checkResidencia.disabled = !enableResidencia;
        inputResidencia.disabled = !enableResidencia;
        inputResidencia.required = enableResidencia; // Hacer obligatorio si es necesario
        if (enableResidencia) {
            checkResidencia.checked = true; // Seleccionar automáticamente
        } else {
            checkResidencia.checked = false;
            inputResidencia.value = '';
        }

        checkTrabajo.disabled = !enableTrabajo;
        inputTrabajo.disabled = !enableTrabajo;
        inputTrabajo.required = enableTrabajo; // Hacer obligatorio si es necesario
        if (enableTrabajo) {
            checkTrabajo.checked = true; // Seleccionar automáticamente
        } else {
            checkTrabajo.checked = false;
            inputTrabajo.value = '';
        }
    }

    // Función para habilitar/deshabilitar los campos adicionales si se selecciona "Trabajador por cuenta propia" o "Trabajador por cuenta ajena"
    function toggleCamposTrabajador(enable) {
        categoriaProfesionalRadios.forEach(radio => {
            radio.disabled = !enable;
            radio.required = enable;
        });
        horarioCursoRadios.forEach(radio => {
            radio.disabled = !enable;
            radio.required = enable;
        });
        tamanoEmpresaRadios.forEach(radio => {
            radio.disabled = !enable;
            radio.required = enable;
        });
        otroTrabajoInput.disabled = !enable;

        // Deshabilitar opciones de jornada laboral hasta que se seleccione "Dentro de la jornada laboral" o "Ambas" en "Horario del curso"
        jornadaCursoRadios.forEach(radio => {
            radio.disabled = true;
            radio.required = false;
        });
    }

    // Función para habilitar/deshabilitar las opciones de "Jornada laboral" según "Horario del curso"
    function toggleJornadaLaboralOptions() {
        if (document.getElementById('horario_dentro').checked || document.getElementById('horario_ambas').checked) {
            jornadaCursoRadios.forEach(radio => {
                radio.disabled = false;
                radio.required = true;
            });
        } else {
            jornadaCursoRadios.forEach(radio => {
                radio.disabled = true;
                radio.required = false;
            });
        }
    }

    // Escuchar cambios en la situación laboral
    document.querySelectorAll('input[name="sit_laboral"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (desempleadoRadio.checked) {
                toggleSuspensionOptions(true); // Habilitar opciones de suspensión de la demanda
                toggleLugarCampos(true, false); // Habilitar lugar de residencia, seleccionarlo y hacerlo obligatorio
                toggleCamposTrabajador(false); // Deshabilitar campos adicionales
            } else if (cuentaPropiaRadio.checked || cuentaAjenaRadio.checked) {
                toggleSuspensionOptions(false); // Deshabilitar opciones de suspensión de la demanda
                toggleLugarCampos(false, true); // Habilitar lugar del centro de trabajo, seleccionarlo y hacerlo obligatorio
                toggleCamposTrabajador(true); // Habilitar campos adicionales
            } else {
                toggleSuspensionOptions(false); // Deshabilitar ambas opciones de suspensión
                toggleLugarCampos(false, false); // Deshabilitar ambos campos de lugar
                toggleCamposTrabajador(false); // Deshabilitar campos adicionales
            }
        });
    });

    // Escuchar cambios en "Horario del curso" para habilitar/deshabilitar "Jornada laboral"
    horarioCursoRadios.forEach(radio => {
        radio.addEventListener('change', toggleJornadaLaboralOptions);
    });
});
</script>

<!-- JavaScript para capturar la firma -->
    <script>
        // Inicializar jSignature
        $(document).ready(function() {
            $("#signature").jSignature(); // Inicializa el campo de firma
        });

        // Función para capturar la firma en base64
        function captureSignature() {
            var signatureData = $("#signature").jSignature("getData", "image"); // Obtener la firma en base64
            if (signatureData.length === 0) {
                alert("Por favor, dibuja tu firma.");
                return false;
            }
            document.getElementById('signatureData').value = signatureData[1]; // Guardar la firma en el campo oculto
            return true;
        }

        // Función para borrar la firma
        function clearSignature() {
            $("#signature").jSignature("reset"); // Borrar la firma del campo
        }
    </script>

    <script src="validate.js" type="text/javascript"></script>
</body>
</html>