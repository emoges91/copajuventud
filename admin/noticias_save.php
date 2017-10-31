<?php
include('conexiones/conec_cookies.php');

$sFeatured = (isset($_POST['featured']) ? $_POST['featured'] : '0');
$sTitulo = (isset($_POST['TITULO']) ? $_POST['TITULO'] : '');
$sFecha = (isset($_POST['FECHA']) ? $_POST['FECHA'] : '');
$sDCorta = (isset($_POST['DC']) ? $_POST['DC'] : '');
$aFoto = (isset($_FILES['foto']) ? $_FILES['foto'] : '');

$sPath = 'noticias/';

if (( $sTitulo != '') && ($sFecha != '') && ( $sDCorta != '')) {
    $dir = date("YnjHis");
    $sURLFoto = '';
    if (is_uploaded_file($aFoto['tmp_name'])) {

        @mkdir($sPath . $dir, 0777, true);
        copy($aFoto['tmp_name'], $sPath . $dir . "/" . $aFoto['name']); 
        $sURLFoto = $sPath . $dir . "/" . $aFoto['name'];
    }
    $sql = "
        INSERT INTO t_noticias 
        ( TITULO, FECHA, DESCRIPCION_CORTA, URL_IMAGEN, FEATURED) 
        VALUES (
        '" . $sTitulo . "',
        '" . $sFecha . "',
        '" . $sDCorta . "',
        '" . $sURLFoto . "',
        '" . $sFeatured . "'
        )";

    $query = mysql_query($sql, $conn);
    echo "
        <script type=\"text/javascript\">
        alert('Noticia publicada correctamente');
        document.location.href='noticias.php';
        </script>";
}
else
    echo "
        <script type=\"text/javascript\">
        alert('Los campos con asterisco (*) son requeridos');
        history.go(-1);
        </script>";
?>