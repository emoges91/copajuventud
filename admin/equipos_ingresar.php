<?php

include ('conexiones/conec_cookies.php');
$sNomb = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$sCanOfi = (isset($_POST['canofi'])) ? $_POST['canofi'] : '';
$sCanAlt = (isset($_POST['canalt'])) ? $_POST['canalt'] : '';

if ($sNomb != '') {

    $urlimg = '';
    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
        @mkdir("imgen/" . $sNomb);
        copy($_FILES['logo']['tmp_name'], "imgen/" . $sNomb . "/" . $_FILES['logo']['name']);
        $subio = true;
        $urlimg = "imgen/" . $sNomb . "/" . $_FILES['logo']['name'];
    }
    if ($_POST['activo'] == true) {
        $act = 1;
    } else {
        $act = 0;
    }

    $sql = "INSERT INTO t_equipo 
        VALUES (null,
                '" . $sNomb . "',
                '" . $act . "',
                '" . $sCanOfi . "',
                '" . $sCanAlt  . "',
                '" . $urlimg . "')
		";

    $query = mysql_query($sql, $conn) or die(mysql_error());

    echo "<script type=\"text/javascript\">
		alert('El equipo fue registrado');document.location.href='equipos.php';
		</script>";
} else {
    echo "<script type=\"text/javascript\">alert('Los campos con asterisco (*) son requeridos');history.go(-1);</script>";
}
?>