
function obtenerValorDNI(evt){
    document.getElementById("caja-usuario").value = document.getElementById("caja-dniC").value;
}

function lengthDNI(){
    
    var dni = document.getElementById("caja-dniC").value;
    
    if (dni < 8) {
        alert("dbe completar el dni");
        return false;
        
    }else if (dni > 8) {
        alert("dbe completar el dni");
        return false;
    }
    
}

//Se utiliza para que el campo de texto solo acepte numeros
function SoloNumeros(evt) {
    
    if (window.event) {
        //asignamos el valor de la tecla a keynum
        keynum = evt.keyCode;
    }
    else {
        keynum = evt.which;
    }
    //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6) {
        return true;
        
    }
    else {
        return false;
    }
    
}

//Se utiliza para que el campo de texto solo acepte letras
function soloLetras(e) {

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    //Se define todo el abecedario que se quiere que se muestre.
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    //Es la validación del KeyCodes, que teclas recibe el campo de texto.
    especiales = [8, 37, 39, 46, 6]; 

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

