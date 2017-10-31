<?php
include ('../../conexiones/conec_cookies.php');
include ('../../FPHP/funciones.php');


if (
	(isset($_POST['descripcion']) and ($_POST['descripcion'] !='')) and
	 (isset($_POST['fecha']) and ($_POST['fecha'] !=''))
	)
	{
		$url_documento = '';				
	   	if(is_uploaded_file($_FILES['documento']['tmp_name']))
	   	{
	  	  @mkdir("archivos/".$_POST['descripcion']);
		  copy($_FILES['documento']['tmp_name'], "archivos/".$_POST['descripcion']."/".$_FILES['documento']['name']);  	  
		  $subio = true;
		  $url_documento = "archivos/".$_POST['descripcion']."/".$_FILES['documento']['name'];
     	}
		 
		$sql = "INSERT INTO T_DOC_AMI VALUES (null,
										'".$_POST['fecha']."',
										'".$_POST['descripcion']."',
										'".$url_documento."',
										'".$_POST['datos']."',
										'".$_POST['id_tor']."')";
										
										
		$query = mysql_query($sql, $conn)or die(mysql_error());

		echo "<script type=\"text/javascript\">
		alert('El Documento fue subido con exito');document.location.href='registrar_documentos.php?ID=".$_POST['id_tor']."&NOMB=".$_POST['NOMB']."';
		</script>";
	}
	else{
		echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>";
		}
?>