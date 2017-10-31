<?php

include ('conexiones/conec_cookies.php');

$sAsunto = (isset($_POST['asunto'])) ? trim($_POST['asunto']) : '';
$dFecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$aDoc = (isset($_FILES['doc'])) ? $_FILES['doc'] : '';
$nTipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$sPath = 'documentos/';
$sPath2 = '';

if (( $sAsunto != '') && ( $dFecha != '') && ( $nTipo != '')) {

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

    if ($aDoc['size'] != 0 && $aDoc['error'] == 0) {
        @mkdir($sPath . $sPath2 . $sAsunto . '/', 0777, true);
        copy($aDoc['tmp_name'], $sPath . $sPath2 . $sAsunto . '/' . $aDoc['name']);
        $sURLDoc = $sPath . $sPath2 . $sAsunto . '/' . $aDoc['name'];

        $sSql = "
        INSERT INTO t_documentos
            ( 
                ASUNTO, 
                FECHA, 
                URL_DOCUMENTO, 
                TIPO
            )
        VALUES 
        ( 
            '" . $sAsunto . "',
            '" . $dFecha . "',
            '" . $sURLDoc . "',
            " . $nTipo . "
        )";

        $oQuery = mysql_query($sSql);

        echo "
        <script type=\"text/javascript\">
            alert('El Documento fue subido con exito');
            document.location.href='doc.php?tipo=" . $nTipo . "';
        </script>";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert('Error al subir archivo.');
            history.go(-1);
        </script>";
    }
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Los campos con asterisco (*) son requeridos');
            history.go(-1);
        </script>";
}
?>