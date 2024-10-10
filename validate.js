//capturando variables del formulario
let dni = document.getElementById("dni")
let letra = document.getElementById("letra")
let naciaonalidad = document.getElementById("nacionalidad")
let apellido = document.getElementById("apellidos")
let nombre = document.getElementById("nombre")
let fechaNacimiento = document.getElementById("fnacimiento")
let tel1 = document.getElementById("tel")
let tel2 = document.getElementById("movil1")
let email = document.getElementById("email")
let direccion = document.getElementById("direccion")
let numeroCasa = document.getElementById("numero")
let pisoCasa = document.getElementById("piso")
let codigoPostal = document.getElementById("codpost")
let provincia = document.getElementById("provincia")
let localidad = document.getElementById("localidad")

//variable de mensaje de error
let errorDni = document.getElementById("error-dni")
let errorLetra = document.getElementById("error-letra")

let errorNacionalidad = document.getElementById("error-nacionalidad")
let errorNombre = document.getElementById("error-nombre")
let errorApellido = document.getElementById("error-apellido")
let errorTel1 = document.getElementById("error-tel1")

let errorEmail= document.getElementById("error-email")
let errorDireccion= document.getElementById("error-direccion")
let errorNumeroCasa= document.getElementById("error-Ncalle")
let errorPisoCasa= document.getElementById("error-Npiso")
let errorCodigoPostal= document.getElementById("error-cp")
let errorProvincia = document.getElementById("error-provincia")
let errorLocalidad= document.getElementById("error-localidad")



//valiedando fecha de nacimiento
let hoy = new Date();
let dia = hoy.getDate();
let mes = hoy.getMonth() + 1;
let anio = hoy.getFullYear();

if (dia < 10) {
    dia = "0" + dia;
}

if (mes < 10) {
    mes = "0" + mes;
}
let fechaMax = anio + "-" + mes + "-" + dia;
fechaNacimiento.setAttribute("max", fechaMax);




//VALIDACION DNI

dni.addEventListener("blur", () => {

 
    if (dni.value == "") {
        errorDni.style.display = "block"
        errorDni.textContent = "Introduzca un documento válido"
    }
    else if (dni.value.length < 9) {
        errorDni.style.display = "block"
        errorDni.textContent = "Introduzca un documento válido"
    }
    else {
        errorDni.textContent = ""
        errorDni.style.display = "none"
    }
})
let regNumDoc = /^[TRWAGMYFPDXBNJZSQVHLCKEtrwagmyfpdxbnjzsqvhlcke]+$/



//VALIDACION LETRA
letra.addEventListener("input", () => {

    letra.value = letra.value.toUpperCase();
    if (letra.value == "1" || letra.value == "2" || letra.value == "3" || letra.value == "4" || letra.value == "5" || letra.value == "6" || letra.value == "7" || letra.value == "8" || letra.value == "9" || letra.value == "0") {
        letra.value = "";
    }
})
letra.addEventListener("blur", () => {

    if (letra.value == "") {
        errorLetra.style.display = "block"
        errorLetra.textContent = "Introduzca letra"
    }
    else if (!regNumDoc.test(letra.value)) {
        errorLetra.style.display = "block"
        errorLetra.textContent = "letra no válida"
    }
    else {
        errorLetra.textContent = ""
        errorLetra.style.display = "none"
    }

})

//VALIDACION NACIONALIDAD
naciaonalidad.addEventListener("input", () => {

    if (naciaonalidad.value == "1" || naciaonalidad.value == "2" || naciaonalidad.value == "3" || naciaonalidad.value == "4" || naciaonalidad.value == "5" || naciaonalidad.value == "6" || naciaonalidad.value == "7" || naciaonalidad.value == "8" || naciaonalidad.value == "9" || naciaonalidad.value == "0") {

        naciaonalidad.value = naciaonalidad.value.replace("0", "");
        naciaonalidad.value = naciaonalidad.value.replace("1", "");
        naciaonalidad.value = naciaonalidad.value.replace("2", "");
        naciaonalidad.value = naciaonalidad.value.replace("3", "");
        naciaonalidad.value = naciaonalidad.value.replace("4", "");
        naciaonalidad.value = naciaonalidad.value.replace("5", "");
        naciaonalidad.value = naciaonalidad.value.replace("6", "");
        naciaonalidad.value = naciaonalidad.value.replace("7", "");
        naciaonalidad.value = naciaonalidad.value.replace("8", "");
        naciaonalidad.value = naciaonalidad.value.replace("9", "");

    }
})
naciaonalidad.addEventListener("blur", () => {
    if (naciaonalidad.value == "") {
        errorNacionalidad.style.display = "block"
        errorNacionalidad.textContent = "Introduzca Nacionalidad"
    }

    else {
        errorNacionalidad.textContent = ""
        errorNacionalidad.style.display = "none"
    }
})

//VALIDACION APELLIDO

apellido.addEventListener("input", () => {

    if (apellido.value == "1" || apellido.value == "2" || apellido.value == "3" || apellido.value == "4" || apellido.value == "5" || apellido.value == "6" || apellido.value == "7" || apellido.value == "8" || apellido.value == "9" || apellido.value == "0") {

        apellido.value = apellido.value.replace("0", "");
        apellido.value = apellido.value.replace("1", "");
        apellido.value = apellido.value.replace("2", "");
        apellido.value = apellido.value.replace("3", "");
        apellido.value = apellido.value.replace("4", "");
        apellido.value = apellido.value.replace("5", "");
        apellido.value = apellido.value.replace("6", "");
        apellido.value = apellido.value.replace("7", "");
        apellido.value = apellido.value.replace("8", "");
        apellido.value = apellido.value.replace("9", "");

    }
})
apellido.addEventListener("blur", () => {
    if (apellido.value == "") {
        errorApellido.style.display = "block"
        errorApellido.textContent = "Introduzca Apellidos"
    }

    else {
        errorApellido.textContent = ""
        errorApellido.style.display = "none"
    }
})

//VALIDACION NOMBRE
nombre.addEventListener("input", () => {

    if (nombre.value == "1" || nombre.value == "2" || nombre.value == "3" || nombre.value == "4" || nombre.value == "5" || nombre.value == "6" || nombre.value == "7" || nombre.value == "8" || nombre.value == "9" || nombre.value == "0") {

        nombre.value = nombre.value.replace("0", "");
        nombre.value = nombre.value.replace("1", "");
        nombre.value = nombre.value.replace("2", "");
        nombre.value = nombre.value.replace("3", "");
        nombre.value = nombre.value.replace("4", "");
        nombre.value = nombre.value.replace("5", "");
        nombre.value = nombre.value.replace("6", "");
        nombre.value = nombre.value.replace("7", "");
        nombre.value = nombre.value.replace("8", "");
        nombre.value = nombre.value.replace("9", "");

    }
})
nombre.addEventListener("blur", () => {
    if (nombre.value == "") {
        errorNombre.style.display = "block"
        errorNombre.textContent = "Introduzca nombre"
    }

    else {
        errorNombre.textContent = ""
        errorNombre.style.display = "none"
    }
})

//VALIDACION TELEFONO 1

tel1.addEventListener("blur", () => {

    let telefono = tel1.value;

    if (tel1.value == "") {
        errorTel1.style.display = "block"
        errorTel1.textContent = "Introduzca teléfono"

    } else if (telefono[0] != 6 && telefono[0] != 7 && telefono[0] != 9) {

        errorTel1.style.display = "block"
        errorTel1.textContent = "número de teléfono invalido"
    }


    else {
        errorTel1.textContent = ""
        errorTel1.style.display = "none"
    }


})


//VALIDACION EMAIL
let regTexto= /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{3,}\.[a-zA-Z]{2,6}$/
email.addEventListener("blur",()=>{

    if (email.value == "") {
        errorEmail.style.display = "block"
        errorEmail.textContent = "Introduzca email"

    } else if (regTexto.test(email.value) == false) {

        errorEmail.style.display = "block"
        errorEmail.textContent = "email incorrecto"
    }

    else {
        errorEmail.textContent = ""
        errorEmail.style.display = "none"
    }

})

//VALIDACION DIRECCION
direccion.addEventListener("blur", () => {
    if (direccion.value == "") {
        errorDireccion.style.display = "block"
        errorDireccion.textContent = "Introduzca una Dirección"
    }

    else {
        errorDireccion.textContent = ""
        errorDireccion.style.display = "none"
    }
})


//VALIDACION NUMERO DE CALLE
numeroCasa.addEventListener("blur", () => {
    if (numeroCasa.value == "") {
        errorNumeroCasa.style.display = "block"
        errorNumeroCasa.textContent = "Introduzca el número"
    }

    else {
        errorNumeroCasa.textContent = ""
        errorNumeroCasa.style.display = "none"
    }
})
//VALIDACION NUMERO DE PISO
pisoCasa.addEventListener("blur", () => {
    if (pisoCasa.value == "") {
        errorPisoCasa.style.display = "block"
        errorPisoCasa.textContent = "Introduzca el piso"
    }

    else {
        errorPisoCasa.textContent = ""
        errorPisoCasa.style.display = "none"
    }
})


//VALIDACION NUMERO CP
let soloNumero=/^[a-zA-Z\.\,\´-]$/
codigoPostal.addEventListener("input",()=>{

    if(soloNumero.test(codigoPostal.value)==true){

        codigoPostal.value=codigoPostal.value.replace(soloNumero,"")
    }
})
codigoPostal.addEventListener("blur", () => {
    if (codigoPostal.value == "") {
        errorCodigoPostal.style.display = "block"
        errorCodigoPostal.textContent = "Introduzca el Codigo Postal"
    }

    else {
        errorCodigoPostal.textContent = ""
        errorCodigoPostal.style.display = "none"
    }
})

//VALIDACION PROVINCIA
provincia.addEventListener("blur", () => {
    if (provincia.value == "") {
        errorProvincia.style.display = "block"
        errorProvincia.textContent = "Introduzca la provincia"
    }

    else {
        errorProvincia.textContent = ""
        errorProvincia.style.display = "none"
    }
})
//VALIDACION LOCALIDAD
localidad.addEventListener("blur", () => {
    if (localidad.value == "") {
        errorLocalidad.style.display = "block"
        errorLocalidad.textContent = "Introduzca la localidad"
    }

    else {
        errorLocalidad.textContent = ""
        errorLocalidad.style.display = "none"
    }
})