<?php

include('conexiones/conec_cookies.php');

$nNoticiaID = (isset($_GET['id'])) ? $_GET['id'] : '';

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

if ($nNoticiaID != '') {
    $sql = "
        select * 
        from t_noticias 
        WHERE ID=" . $nNoticiaID;
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);

    $sSlash = strrpos($row['URL_IMAGEN'], '/');
    $nLen = strlen($row['URL_IMAGEN']);
    $sPath = substr($row['URL_IMAGEN'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPath, true);

    $sql = "
    DELETE 
    FROM t_noticias 
    WHERE ID='" . $nNoticiaID . "'";
    $query = mysql_query($sql);
}
header('location: noticias.php ');
?>