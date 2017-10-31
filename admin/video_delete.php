<?php

include('conexiones/conec_cookies.php');

$sql = "DELETE FROM t_video WHERE ID='" . $_GET['ID'] . "'";
$query = mysql_query($sql, $conn);

header('location: videos.php');
?>