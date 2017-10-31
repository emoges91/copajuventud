<?php

include('conexiones/conec_cookies.php');

$sFeatured = (isset($_POST['featured']) ? $_POST['featured'] : '0');
$sTitulo = (isset($_POST['TITULO']) ? $_POST['TITULO'] : '');
$sFecha = (isset($_POST['FECHA']) ? $_POST['FECHA'] : '');
$sDCorta = (isset($_POST['DC']) ? $_POST['DC'] : '');
$nNoticiaID = (isset($_POST['id'])) ? $_POST['id'] : '';
$aFoto = (isset($_FILES['foto']) ? $_FILES['foto'] : '');

function borrar_directorio($psDir, $bBorrarme) {
    if (!$dh = @opendir($psDir))
        return;
    while (false !== ($obj = readdir($dh))) {
        if ($obj == '.' || $obj == '..')
            continue;
        if (!@unlink($psDir . '/' . $obj))
            borrar_directorio($psDir . '/' . $obj, true);
    }
    closedir($dh);
    if ($bBorrarme) {
        @rmdir($psDir);
    }
}

$sPath = 'noticias/';

if ($sTitulo != '' && $sFecha != '' && $sDCorta != '') {

    $sql = "
        select * 
        from t_noticias 
        WHERE ID=" . $nNoticiaID;
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);

    $sSlash = strrpos($row['URL_IMAGEN'], '/');
    $nLen = strlen($row['URL_IMAGEN']);
    $sPathOld = substr($row['URL_IMAGEN'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPathOld, true);

    $dir = date("YnjHis");
    $sURLFoto = '';

    if (is_uploaded_file($aFoto['tmp_name'])) {
        @mkdir($sPath . $dir, 0777, true);
        copy($aFoto['tmp_name'], $sPath . $dir . "/" . $aFoto['name']);
        $sURLFoto = $sPath . $dir . "/" . $aFoto['name'];
    }
    $sql = "
        UPDATE t_noticias 
            SET
                TITULO = '" . $sTitulo . "',
                FECHA = '" . $sFecha . "',
                DESCRIPCION_CORTA = '" . $sDCorta . "',
                FEATURED = '" . $sFeatured . "',
                URL_IMAGEN = '" . $sURLFoto . "'
        WHERE ID = '" . $nNoticiaID . "'";
    $query = mysql_query($sql);

    echo "
        <script type=\"text/javascript\">
        alert('Noticia editada correctamente');
        document.location.href='noticias.php';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
        alert('Los campos con asterisco (*) son requeridos');
        history.go(-1);
        </script>";
}
?>