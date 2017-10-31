<?php

include ('conexiones/conec_cookies.php');
include_once("module/imageresize.class.php");

$cadena = $_POST['cadena'];


$cadenas = explode('/', $cadena);
$nro_cadenas = count($cadenas);
$codalb = $cadenas[0];
$url = $cadenas[1];
$i = 2;



while ($i < $nro_cadenas) {
    $urlfoto = "album/original/" . $url . "/" . $cadenas[$i];
    $urlthumbs = "album/thumbs/" . $url . "/" . $cadenas[$i];
    $urlthumbs300 = "album/thumbs300/" . $url . "/" . $cadenas[$i];

    $source = "album/original/" . $url . "/" . $cadenas[$i];
    $dest = "thumbs/" . $url . "/" . $cadenas[$i];
    @unlink($dest);

    
    $oResize = new ImageResize($source);
    $oResize->resizeWidth(150);
    $oResize->save($dest);
    echo 'hi3';
    
    $source = "album/original/" . $url . "/" . $cadenas[$i];
    $dest = "thumbs300/" . $url . "/" . $cadenas[$i];
    @unlink($dest);
    $oResize = new ImageResize($source);
    $oResize->resizeWidth(300);
    $oResize->save($dest);

    $sql = "INSERT INTO T_IMG VALUES (null,'" . $cadenas[$i] . "','" . $cadenas[$i] . "','" . $urlfoto . "','" . $cadenas[0] . "','" . $urlthumbs . "','" . $urlthumbs300 . "')";
    $query = mysql_query($sql, $conn);
    $i++;
}
$ssel = "SELECT * FROM T_IMG WHERE ALBUN='" . $codalb . "' ORDER BY ID DESC LIMIT 1";
$quse = mysql_query($ssel, $conn);
$row = mysql_fetch_assoc($quse);

$sel = "SELECT * FROM T_ALBUN WHERE ID='" . $codalb . "'";
$qse = mysql_query($sel, $conn);
$selec = mysql_fetch_assoc($qse);
if ($selec['PORTADA'] == 0) {
    $porta = $row['ID'];
} else {
    $porta = $selec['PORTADA'];
}

$fem = date("j/n/Y");
$sql2 = "UPDATE T_ALBUN SET FEC_MOD='" . $fem . "', PORTADA='" . $porta . "' WHERE ID='" . $codalb . "'";
$query2 = mysql_query($sql2, $conn);
echo "Imagen(es) cargada(s) correctamente. (Para volver clic en Volver)";
?>