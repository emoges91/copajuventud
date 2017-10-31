<head>
 <link href="css/datos_manuales.css" rel="stylesheet" type="text/css" /> 
 </head>
 
<?php
include('../../conexiones/conec_cookies.php');
$consulta="SELECT * FROM T_DOC_AMI WHERE ID=".$_GET['id']."";
$cadena=mysql_query($consulta,$conn);
while ($row= mysql_fetch_assoc($cadena))
{
?>

<div id="Contenedor" align="center">
	<form action="guardar_doc_editado.php" method="post"  enctype="multipart/form-data">
    
    
    	<div id="fecha">
    		Fecha:<input id="demo1" type="text" size="19" align="top" name="fecha" value="<?php echo $row['FECHA'] ?>"><a href="javascript:NewCal('demo1','ddmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
   		 </div>
         
   		 <div id="descripcion">
   			 Nota:
             <textarea rows="3" cols="25" name="descripcion"><?php echo $row['NOTAS'] ?></textarea>
   		 </div>
    
    	
    	<div id="opcion">
         <?php
		 	if($row['TIPO']==0)
			{
			echo 'Opcion:<input type="radio" value="0" name="datos" checked="checked"/>Jugadores Sancionados';
            	  echo' <input type="radio" value="1" name="datos" />Otros Documentos';
			}
			else
			{
				echo 'Opcion:<input type="radio" value="0" name="datos"/>Jugadores Sancionados';
            	  echo' <input type="radio" value="1" name="datos" checked="checked" />Otros Documentos';
			}
		 ?>
    
    	</div>
    
   	    <div id="url_documento">
        	Archivo:<input type="file" name="documento"/>
        </div>
        <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB']; ?>"/>
        <input type="hidden" name="id_tor" value="<?php echo $_GET['id_torneo']; ?>"/>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
        <input type="hidden" name="bolean" value="<?php echo $row['URL_DOCUMENTO']; ?>"/>
        <input type="hidden" name="borrar_carpeta" value="<?php echo $row['NOTAS']; ?>" />
        
    <br />
		<div id="botones" align="center">
        	<input type="submit" value="Guardar" />
            <input type="button" value="Atras" onclick="document.location.href='registrar_documentos.php?ID=<?php echo $_GET['id_torneo'];?>&NOMB=<?php echo $_GET['NOMB'];?>';"            />
        </div>    
   </form>
 </div>
 
<?php } ?>