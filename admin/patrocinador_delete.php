<?php

include('conexiones/conec_cookies.php');

$nPID = (isset($_GET['id'])) ? $_GET['id'] : '';
$sDir = (isset($_GET['direccion']) ? $_GET['direccion'] : '');

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

if ($nPID != '') {
    $sql = "
        select * 
        from t_patrocinador 
        WHERE ID=" . $nPID;
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);

    $sSlash = strrpos($row['URL'], '/');
    $nLen = strlen($row['URL']);
    $sPath = substr($row['URL'], 0, -($nLen - $sSlash - 1));
    borrar_directorio($sPath, true);

    $sql = "DELETE FROM t_patrocinador WHERE ID='" . $nPID . "'";
    $query = mysql_query($sql);
}


echo "
    <script type=\"text/javascript\">
    alert('Patrocinador eliminado correctamente');
    document.location.href='patrocinador.php';
    </script>";
?>