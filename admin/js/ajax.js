function Ajax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function EnviarDatos(cadena) {
    ajax = Ajax();
    ajax.open("POST", "fotos_save.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            alert(ajax.responseText);
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("cadena=" + cadena)
}

