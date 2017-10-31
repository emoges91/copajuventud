<?php

include('conexiones/conec_cookies.php');

$sEmpresa = (isset($_POST['empresa']) ? $_POST['empresa'] : '');
$sMostrar = (isset($_POST['mostrar']) ? $_POST['mostrar'] : '0');
$sDir = (isset($_POST['direccion']) ? $_POST['direccion'] : '');

if ($sEmpresa != '') {

    $sFotoURL = '';
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        @mkdir("patrocinadores/" . $_POST['empresa'], 0777, true);
        copy($_FILES['foto']['tmp_name'], "patrocinadores/" . $_POST['empresa'] . "/" . $_FILES['foto']['name']);
        $subio = true;
        $sFotoURL = "patrocinadores/" . $_POST['empresa'] . "/" . $_FILES['foto']['name'];
    }
    $sql = "INSERT INTO t_patrocinador 
                ( EMPRESA, DIRECCION, URL, MOSTRAR)
           VALUES (
                '" . $sEmpresa . "',
                '" . $sDir . "',
                '" . $sFotoURL . "',
                '" . $sMostrar . "'
                )";

    $query = mysql_query($sql);
    echo "
        <script type=\"text/javascript\">
        alert('Patrocinador registrado correctamente');
        document.location.href='patrocinador.php';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
        alert('Los campos con asterisco (*) son requeridos');
        history.go(-1);
        </script>";
}
?>