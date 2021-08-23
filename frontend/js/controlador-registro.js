function guardar() {
    if(validarVacio('nombre') && validarVacio('apellido') && validarVacio('email') &&
    validarVacio('password') && validarVacio('confirmar') && validarVacio('direccion') &&
    validarVacio('fecha') && validarVacio('telefono')){
        if(validarEmail(document.getElementById('email').value)){
            if(validarPassswor()){
                enviarDatos();
            }
        }
    }
}

function validarVacio(id) {
    const campo = document.getElementById(id);
    if(campo.value == ''){
        campo.classList.add('error-vacio');
        return false;
    }
    else {
        campo.classList.remove('error-vacio');
        return true;
    } 
}

function validarEmail(email) {
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if(regex.test(email))
        return true;
    else
        return false;
}

function validarPassswor() {
    let password = document.getElementById('password').value;
    let confirmar = document.getElementById('confirmar').value;
    if(password == confirmar){
        return true;
    }
    else {
        return false;
    }
}

function enviarDatos(){
    let datos = {
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        correo: document.getElementById('email').value,
        password: document.getElementById('password').value,
        direccion: document.getElementById('direccion').value,
        fecha: document.getElementById('fecha').value,
        telefono: document.getElementById('telefono').value
    }
    axios({
        method: 'POST',
        url: '../../../womanstore/backend/api/usuarios.php',
        responseType: 'text',
        data: datos
    }).then(res=>{
        if(res.data == "Ingresado Correctamente"){
            dirreccion(res.data);
        }
        else{
            const mensaje = res.data;
            alert(mensaje);
        }
        console.log(res.data);
    }).catch(err=>{
        console.log(err);
    });
    console.log(datos);
}

function dirreccion(respuesta) {
    if(respuesta)
        window.location.href = 'http://localhost/womanstore/prueba.html';
    else {
        alert("Usuario no registrado");
        //enctype="multipart/form-data"
    }
}