<html>
<head>
<script language="javascript">
	function callprogress(vValor)
	{
		document.getElementById("getprogress").innerHTML = vValor
		document.getElementById("getprogressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>'	
	}
</script>

<style type="text/css">
	.ProgressBar {width: 16em; border:1px solid black; background:#eef; height:1.25em; display:block;}
	.ProgressBarText {position:absolute; font-size: 1em; width:16em; text-align:center; font-weight:normal}
	.ProgressBarFill {height:100%; background:#aae;; display:block; overflow:visible;}
</style>

</head>
<?php
	include('../conexiones/conec_cookies.php');
	include_once("imageresize.class.php");
	$sqlalbun = "SELECT * FROM T_ALBUN WHERE ID = " .$_GET['ID'];
	$queryalbun = mysql_query($sqlalbun, $conn) or die (mysql_error());
	$rowalbun=mysql_fetch_assoc($queryalbun);
	$ccdal = @mkdir('original/'.$rowalbun['URL']);
	$ccdalthumbs = @mkdir('thumbs/'.$rowalbun['URL']);
	$ccdalthumbs300 = @mkdir('thumbs300/'.$rowalbun['URL']);
	if ($ccdal and $ccdalthumbs and $ccdalthumbs300)
	{
		$sql = "SELECT * FROM T_IMG WHERE ALBUN = ".$rowalbun['ID'];
		$query = mysql_query($sql, $conn)or die(mysql_error());
		$cant = mysql_num_rows($query);
		echo 'Se van a mover '.$cant.' archivos de la galeria.<br/>
		<div class="ProgressBar">
		<div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completados</div>
    	<div id="getprogressBarFill"></div>
		</div><br/>';
		$i=0;
		while ($row=mysql_fetch_assoc($query))
		{
			@copy('../'.$row['URL'],'original/'.$rowalbun['URL'].'/'.$row['NOMBRE']);
			//$source = "../".$row['URL'];
    		//$dest = "original/".$rowalbun['URL'].'/'.$row['NOMBRE'];
    		//@unlink($dest);
    		//$oResize = new ImageResize($source);
			//$oResize->resizeWidth(1000);
			//$oResize->save($dest);	
			$source = "../".$row['URL'];
    		$dest = "thumbs/".$rowalbun['URL'].'/'.$row['NOMBRE'];
    		@unlink($dest);
    		$oResize = new ImageResize($source);
			$oResize->resizeWidth(150);
			$oResize->save($dest);	
			$source = "../".$row['URL'];
    		$dest = "thumbs300/".$rowalbun['URL'].'/'.$row['NOMBRE'];
    		@unlink($dest);
    		$oResize = new ImageResize($source);
			$oResize->resizeWidth(300);
			$oResize->save($dest);
			@unlink("../".$row['URL']);
			@rmdir($rowalbun['URL']);
			$i++;
			$actualizar = "UPDATE T_IMG SET 		
										URL='"."imgen/original/".$rowalbun['URL']."/".$row['NOMBRE']."',
										URL_THUMB='"."imgen/thumbs/".$rowalbun['URL']."/".$row['NOMBRE']."',
										URL_THUMB300='"."imgen/thumbs300/".$rowalbun['URL']."/".$row['NOMBRE']."'
				WHERE ID=".$row['ID'];
			$queryactualizar = mysql_query($actualizar, $conn)or die(mysql_error());
			echo 'Se han movido '.$i.' de '.$cant.' de archivos.<br/>';
			$porcentaje = $i*100/$cant;
			echo "<script>callprogress(".round($porcentaje).")</script>";
			flush();
			ob_flush();
		}
		//echo "<script type=\"text/javascript\">
			//	alert('El albun fue editado correctamente.');
		//		document.location.href='index_cambio.php?COD=".$_GET['COD']."';
		//	/<script>";	
	}
	else
	{
		echo "<script type=\"text/javascript\">
		alert('Se ha producido un error al crear los directorios de la galeria.');
		history.go(-1);
	</script>";
	}
	echo '<a href="index_cambio.php?COD='.$_GET['COD'].'">Continuar</a>';
?>