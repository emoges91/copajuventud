<?php

include('conexiones/conec_cookies.php');
if (
        (isset($_POST['NOMBRE']) && ($_POST['NOMBRE'] != '')) &&
        (isset($_POST['DESCRIP']) && ($_POST['DESCRIP'] != ''))
) {
    $sql = "
        UPDATE t_img 
        SET 		
            NOMBRE='" . $_POST['NOMBRE'] . "',
            DESCRIP='" . $_POST['DESCRIP'] . "'
        WHERE ID=" . $_POST['ID'];

    $query = mysql_query($sql, $conn);
    $fem = date("j/n/Y");
    $codalb = $_POST['IDR'];
    echo $_POST['PORTADA'];
    if ($_POST['PORTADA'] == on) {
        $sql2 = "UPDATE t_albun SET FEC_MOD='" . $fem . "', PORTADA='" . $_POST['ID'] . "' WHERE ID='" . $codalb . "'";
    } else {
        $sql2 = "UPDATE t_albun SET FEC_MOD='" . $fem . "' WHERE ID='" . $codalb . "'";
    }
    $query2 = mysql_query($sql2, $conn);


    echo "<script type=\"text/javascript\">
				alert('La imagen fue editada con exito');
				document.location.href='fotos.php?ID=" . $_POST['IDR'] . "&pg=" . $_POST['PAG'] . "';
		 	</script>";
} else {
    echo "<script type=\"text/javascript\">
		alert('Debe de digitar un nombre y una descripcion');
		history.go(-1);
	</script>";
}
?>