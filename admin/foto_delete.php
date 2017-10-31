<?php

include('conexiones/conec_cookies.php');
$sqlselect = "SELECT * FROM t_img WHERE ID='" . $_GET['id'] . "'";
$queryselect = mysql_query($sqlselect, $conn);
$row = mysql_fetch_assoc($queryselect);
$ceio = @unlink($row['URL']);
$ceit = @unlink($row['URL_THUMB']);
$ceit3 = @unlink($row['URL_THUMB300']);
$sql = "DELETE FROM t_img WHERE ID='" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn);
header('location: fotos.php?ID=' . $_GET['idp'] . '&pg=' . $_GET['pg'] . '');
?>