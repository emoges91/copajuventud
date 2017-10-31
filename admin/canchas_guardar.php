<?php

include('conexiones/conec_cookies.php');
$sNomb = (isset($_POST['NOMBRE'])) ? $_POST['NOMBRE'] : '';

if ($sNomb != '') {

    $sql = "INSERT INTO t_cancha VALUES (null, '" . $_POST['NOMBRE'] . "', '" . $_POST['DIRECCION'] . "')";
    $query = mysql_query($sql, $conn);

    echo "<script type=\"text/javascript\">alert('Cancha registrado correctamente');document.location.href='registrar_canchas.php';</script>";
} else {

    echo "<script type=\"text/javascript\">alert('Los campos con asterisco (*) son requeridos');history.go(-1);</script>";
}
?>