<?php

include ('conexiones/conec.php');
if (
        (isset($_POST['nombre']) and ($_POST['nombre'] != '')) and
        (isset($_POST['canofi']) and ($_POST['canofi'] != '')) and
        (isset($_POST['canalt']) and ($_POST['canalt'] != ''))
) {

    $urlimg = '';

    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
        @mkdir("imgen/" . $_POST['nombre']);
        copy($_FILES['logo']['tmp_name'], "imgen/" . $_POST['nombre'] . "/" . $_FILES['logo']['name']);
        $subio = true;
        $urlimg = "imgen/" . $_POST['nombre'] . "/" . $_FILES['logo']['name'];
    }
    if ($_POST['activo'] == true) {
        $act = 1;
    } else {
        $act = 0;
    }

    $sql = "UPDATE t_equipo SET 		
										NOMBRE='" . $_POST['nombre'] . "',
										ACTIVO='" . $act . "',
										CAN_OFI='" . $_POST['canofi'] . "',
										CAN_ALT='" . $_POST['canalt'] . "',
										URL='" . $urlimg . "'
				where ID=" . $_POST['ID'];

    $query = mysql_query($sql, $conn) or die(mysql_error());

    echo "<script type=\"text/javascript\">
				alert('El equipo fue editado con exito');
				document.location.href='equipos.php';
			</script>";
} else {
    echo "<script type=\"text/javascript\">
		alert('Los campos con asterisco (*) son requeridos');
		history.go(-1);
	</script>";
}
?>