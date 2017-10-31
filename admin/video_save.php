<?php

include('conexiones/conec_cookies.php');

$nNombre = (isset($_POST['nom'])) ? $_POST['nom'] : '';
$nURL = (isset($_POST['url'])) ? $_POST['url'] : '';
$nDesc = (isset($_POST['des'])) ? $_POST['des'] : '';

if ($nNombre != '' && $nURL != '' && $nDesc != '') {
    
    $temp = explode('=', $nURL);
    $idvideo = "http://img.youtube.com/vi/" . $temp[1] . "/0.jpg";
    $fem = date("j/n/Y");
    
    $sql = "
        INSERT INTO 
        t_video 
        VALUES (null,'" . $nNombre . "','" . $nDesc . "','" . $nURL . "','" . $idvideo . "','" . $fem . "')";
    $query = mysql_query($sql);

    echo "<script type=\"text/javascript\">
				alert('El video fue guardado');document.location.href='videos.php';
			</script>";
} else {
    echo "<script type=\"text/javascript\">
		alert('Se debe digitar un nombre, una descripcion y una URL');
		history.go(-1);
	</script>";
}
?>