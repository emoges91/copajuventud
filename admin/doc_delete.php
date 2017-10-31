<?php

include('conexiones/conec_cookies.php');

$nTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '';
$nDocID = (isset($_GET['id'])) ? $_GET['id'] : '';
$sAsunto = (isset($_GET['asunto'])) ? trim($_GET['asunto']) : '';

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

$sPath = 'documentos/';
$sPath2 = '';


if (trim($nTipo) != '') {

    $sSql = "SELECT * FROM t_documentos WHERE ID=" . $nDocID . "";
    $oQuery = mysql_query($sSql); //mismo error q en la linea 29
    $aDoc = mysql_fetch_assoc($oQuery);

    $sURLDoc = '';
    switch ($nTipo) {
        case '1':
            $sPath2 = 'reglamento/';
            break;
        case '2':
            $sPath2 = 'disciplinario/';
            break;
        case '3':
            $sPath2 = 'competencia/';
            break;
        case '4':
            $sPath2 = 'otros/';
            break;
        case '6':
            $sPath2 = 'inf_arb/';
            break;
        case '7':
            $sPath2 = 'rev_arb/';
            break;
        case '5':
            $sPath2 = 'costo_arb/';
            break;
    }

    borrar_directorio($sPath . $sPath2 . $sAsunto . '/', true);
    $sSql = "DELETE FROM t_documentos WHERE ID='" . $nDocID . "'";
    $oQuery = mysql_query($sSql);
}

header('location: doc.php?tipo=' . $nTipo . '');
?>