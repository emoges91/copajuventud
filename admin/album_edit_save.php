<?php

include('conexiones/conec_cookies.php');

if ((isset($_POST['NOMBRE']) and $_POST['NOMBRE'] != '') and (isset($_POST['DIR']) and $_POST['DIR'] != '')) {
    $sql = "
        UPDATE t_albun 
        SET 
        NOMBRE = '" . $_POST['NOMBRE'] . "', 
        DESCRIP = '" . $_POST['DIR'] . "' 
        WHERE ID = '" . $_POST['ID'] . "'";
    $query = mysql_query($sql);
    
    echo "
        <script type=\"text/javascript\">
        alert('Albun editado correctamente');
        document.location.href='album.php?ID=" . $_POST['ID'] . "&pg=" . $_POST['pg'] . "';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
        alert('Se requiere nombre y descripcion');
        history.go(-1);
        </script>";
}
?>