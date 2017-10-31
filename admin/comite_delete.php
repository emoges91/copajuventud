<?php
include('conexiones/conec_cookies.php');

$nTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '';
$sNombre = (isset($_GET['nombre'])) ? $_GET['nombre'] : '';
$nComiteID = (isset($_GET['id'])) ? $_GET['id'] : '';

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

$sPath = 'directiva/';
$sPath2 = '';

if (trim($nComiteID) != '') {

    $sURLDoc = '';
    switch ($nTipo) {
        case '1':
            $sPath2 = 'disciplinario/';
            break;
        case '2':
            $sPath2 = 'competencia/';
            break;
        case '3':
            $sPath2 = 'apelacion/';
            break;
    }

    if ($nTipo == 1) {
        borrar_directorio($sPath . $sPath2 . $sNombre, true);
    }
    if ($nTipo == 2) {
        borrar_directorio($sPath . $sPath2 . $sNombre, true);
    }
    if ($nTipo == 3) {
        borrar_directorio($sPath . $sPath2 . $sNombre, true);
    }
    $sql = "DELETE FROM t_comite WHERE ID='" . $nComiteID . "'";
    $query = mysql_query($sql);
}

header('location: comites.php');
?>