<?php

include('conexiones/conec_cookies.php');

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

$sSql = "
    SELECT * 
    FROM t_img 
    WHERE ALBUN='" . $_GET['ID'] . "'";
$queryselect = mysql_query($sSql, $conn);
while ($row = mysql_fetch_assoc($queryselect)) {

    //////////////////////////////////////////////////////////////////////
    $sSlash = strrpos($row['URL'], '/');
    $nLen = strlen($row['URL']);
    $sPath = substr($row['URL'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPath, true);

    //////////////////////////////////////////////////////////////////////
    $sSlash = strrpos($row['URL_THUMB'], '/');
    $nLen = strlen($row['URL_THUMB']);
    $sPath = substr($row['URL_THUMB'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPath, true);

    //////////////////////////////////////////////////////////////////////
    $sSlash = strrpos($row['URL_THUMB'], '/');
    $nLen = strlen($row['URL_THUMB']);
    $sPath = substr($row['URL_THUMB'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPath, true);

    $sql2 = "DELETE FROM t_img WHERE ID='" . $row['ID'] . "' ";
    $Query = mysql_query($sql2);
}

$sSql = "DELETE FROM t_albun WHERE ID='" . $_GET['ID'] . "'";
$query = mysql_query($sSql);

header('location: album.php');
?>