<?php
include ('admin/conexiones/conec.php');

$sql = "SELECT * FROM t_albun WHERE ID = ".$_GET['ID']."";
$query = mysql_db_query($bd,$sql) or die (mysql_error());
$dato=mysql_fetch_assoc($query);

$cantidadvisitas = $dato['VISITAS'] + 1;

$registarvisitas = "UPDATE t_albun SET VISITAS='".$cantidadvisitas."' WHERE ID='".$_GET['ID']."'";
$queryvisitas = mysql_db_query($bd,$registarvisitas) or die (mysql_error());

header('Location:album_detalle.php?ID='.$_GET['ID'].'&pgpa='.$_GET['ida'].'');
?>
