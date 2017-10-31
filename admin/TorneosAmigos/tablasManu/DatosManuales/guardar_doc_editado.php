<?php
function delete($file) {
					if ($file != "../")
					{
						chmod($file,0777);
						if (is_dir($file)) 
						{
						$handle = opendir($file);
						while($filename = readdir($handle))
						 { 
							if ($filename != "." && $filename != "..") 
							{
							delete($file."/".$filename);
							}
						}
						closedir($handle);
						rmdir($file);//remover carpeta
					} else {
					unlink($file);//remover archivo
				}
				}
			 }

 include('../../conexiones/conec_cookies.php');

if ((isset($_POST['fecha']) and ($_POST['fecha'] !='')))
	{
		   
		  	if($_POST['bolean']!='')
			
		 	 { 
		        delete ('archivos/'.$_POST['borrar_carpeta']);  
			}
			
			$url_documento = '';				
	   	if(is_uploaded_file($_FILES['documento']['tmp_name']))
	   	{
	  	  @mkdir("archivos/".$_POST['descripcion']);
		  copy($_FILES['documento']['tmp_name'], "archivos/".$_POST['descripcion']."/".$_FILES['documento']['name']);  	  
		  $subio = true;
		  $url_documento = "archivos/".$_POST['descripcion']."/".$_FILES['documento']['name'];
     	}
		
		$sql = "UPDATE T_DOC_AMI SET
			FECHA = '".$_POST['fecha']."',
			NOTAS = '".$_POST['descripcion']."',
			URL_DOC='".$url_documento."',
			TIPO = '".$_POST['datos']."',
			ID_TORNEO = '".$_POST['id_tor']."'
			WHERE ID = '".$_POST['id']."'";
										
		$query = mysql_query($sql, $conn)or die(mysql_error());
		echo "<script type=\"text/javascript\">
			alert('Datos editados correctamente');
			document.location.href='registrar_documentos.php?ID=".$_POST['id_tor']."&NOMB=".$_POST['NOMB']."';
		</script>";
			
	   }//Fin del if
?>