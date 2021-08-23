var usuario = [];
function inicioSesion() {
    if(validarVacio('correo') && validarVacio('pass')){
        let datos = {
            "email": document.getElementById('correo').value,
            "password": document.getElementById('pass').value
        }
        console.log(datos.email);
        if(validarEmail(datos.email)){
            axios({
                method: 'POST',
                url: `../../../womanstore/backend/api/usuarios.php?correo=ejemplo@gamil.com`,
                responseType: 'text',
                data: datos
            }).then(res=>{
                if(res.data['mensaje'] == "No se encontro el usuario"){
                    alert(res.data['mensaje']);
                    limpiarCampo('correo');
                    limpiarCampo('pass');
                }
                else{
                    usuario = res.data;
                    window.location.href = 'http://localhost/womanstore/frontend/publicaciones.php';
                }
            }).catch(err=>{
                console.log(err);
            });
            
        }
        else
            alert("Correo no valido");
    }
    else
        alert("Campos vacios");
}

function limpiarCampo(id) {
    document.getElementById(id).value = '';
}

function validarEmail(email) {
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z-0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if(regex.test(email))
        return true;
    else
        return false;
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

function cerrarSesion() {
    axios({
        method: 'GET',
        url: `../../../womanstore/backend/api/usuarios.php?id=${usuario['id']}`,
        responseType: 'text'
    }).then(res=>{
        window.location.href = 'http://localhost/womanstore/index.html';
    }).catch(err=>{
        console.log(err);
    });
}