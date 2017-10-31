<?php
include ('conec_cookies.php');
$cadena=$_POST['cadena'];
$cadenas=explode('/',$cadena);
$nro_cadenas=count($cadenas);
$codalb = $cadenas[0];
$i=1;
while($i<$nro_cadenas){
	$urlfoto="uploads/".$cadenas[$i]; 
	$sql = "INSERT INTO t_img VALUES (null,'".$cadenas[$i]."','".$urlfoto."','".$cadenas[0]."')";		
	$query = mysql_query($sql, $conn)or die(mysql_error());	
	$i++;
}
$temp=$nro_cadenas-1;
echo "Archivos ".$temp." subidos existosamente";
?>