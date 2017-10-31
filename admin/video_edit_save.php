<?php

include("conexiones/conec_cookies.php");

$nNombre = (isset($_POST['NOMBRE'])) ? $_POST['NOMBRE'] : '';
$nURL = (isset($_POST['URL'])) ? $_POST['URL'] : '';
$nDesc = (isset($_POST['DESCRIP'])) ? $_POST['DESCRIP'] : '';

if ($nNombre != '' && $nURL != '' && $nDesc != '') {
    $temp = explode('=', $nURL);
    $idvideo = "http://img.youtube.com/vi/" . $temp[1] . "/0.jpg";
    $sql = "UPDATE t_video SET NOMBRE='" . $nNombre . "', DESCRIP='" . $nDesc . "', URL='" . $nURL . "',URLI='" . $idvideo . "' WHERE ID='" . $_POST['ID'] . "'";

    $query = mysql_query($sql);

    echo "
        <script type=\"text/javascript\">
        alert('El video fue actualizado');
        document.location.href='videos.php';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
        alert('Se debe digitar un nombre, una descripcion y una URL');
        history.go(-1);
	</script>";
}
?>
