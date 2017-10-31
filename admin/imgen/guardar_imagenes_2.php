<?php
include ('../conexiones/conec_cookies.php');
$cadena=$_POST['cadena'];
$cadenas=explode('/',$cadena);
$nro_cadenas=count($cadenas);
$codalb = $cadenas[0];
$url = $cadenas[1];
$i=2;
while($i<$nro_cadenas)
	{
		$urlfoto="imgen/original/".$url."/".$cadenas[$i]; 
		$urlthumbs="imgen/thumbs/".$url."/".$cadenas[$i];
		$urlthumbs300="imgen/thumbs300/".$url."/".$cadenas[$i];
    	include_once("imageresize.class.php");
    	$source = "original/".$url."/".$cadenas[$i];
    	$dest = "thumbs/".$url."/".$cadenas[$i];
    	@unlink($dest);
    	$oResize = new ImageResize($source);
		$oResize->resizeWidth(150);
		$oResize->save($dest);
		$source = "original/".$url."/".$cadenas[$i];
    	$dest = "thumbs300/".$url."/".$cadenas[$i];
    	@unlink($dest);
    	$oResize = new ImageResize($source);
		$oResize->resizeWidth(300);
		$oResize->save($dest);
		$sql = "INSERT INTO T_IMG VALUES (null,'".$cadenas[$i]."','".$cadenas[$i]."','".$urlfoto."','".$cadenas[0]."','".$urlthumbs."','".$urlthumbs300."')";		
		$query = mysql_query($sql, $conn)or die(mysql_error());	
		$i++;
	}		
	$ssel = "SELECT * FROM T_IMG WHERE ALBUN='".$codalb."' ORDER BY ID DESC LIMIT 1";
	$quse = mysql_query($ssel, $conn)or die(mysql_error());
	$row=mysql_fetch_assoc($quse);
	$sel = "SELECT * FROM T_ALBUN WHERE ID='".$codalb."'";
	$qse = mysql_query($sel, $conn)or die(mysql_error());
	$selec=mysql_fetch_assoc($qse);
	if ($selec['PORTADA']==0)
	{
		$porta=$row['ID'];				
	}
	else
	{
		$porta=$selec['PORTADA'];	
	}
	$fem = date("j/n/Y");
	$sql2= "UPDATE T_ALBUN SET FEC_MOD='".$fem."', PORTADA='".$porta."' WHERE ID='".$codalb."'";
	$query2 = mysql_query($sql2, $conn) or die (mysql_error());
?>