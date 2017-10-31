<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar imagenes</title>
<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="scripts/swfobject.js"></script>
<script type="text/javascript" src="scripts/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="scripts/ajax.js"></script>
</head>
<?php
include ("../conexiones/conec_cookies.php");
$sql = "SELECT URL FROM T_ALBUN WHERE ID='".$_GET['ID']."'";		
$query = mysql_query($sql, $conn)or die(mysql_error());
$row = mysql_fetch_assoc($query);
$url = $row['URL']; 
?>
<a href="../detalle_album.php?ID=<?php echo $_GET['ID'];?>">Volver</a>
<body>
<center>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify"/><p>
<a href="javascript:$('#uploadify').uploadifyUpload();">Subir imagenes</a> | 
<a href="javascript:$('#uploadify').uploadifyClearQueue();">Cancelar todo</a></p></div> 
</center>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $("#uploadify").uploadify({
        'uploader'       : 'scripts/uploadify.swf',
        'script'         : 'scripts/uploadify.php',
        'cancelImg'      : 'scripts/cancel.png',
        'folder'         : '<?php echo "original/".$url; ?>',
        'queueID'        : 'fileQueue',
        'auto'           : false,
        'multi'          : true,
		  'buttonText'     : 'Buscar',
		  'fileDesc'       : 'Imagenes',  
		  'fileExt'        : '*.jpg; *.jpeg; *.gif; *.png;',
        'onComplete'     : function(event, a, b, response, data) {
            texto=texto+''+b.name+'/'+'';
        },
        'onAllComplete'  : function(event, d) {
            cadena=texto.substr(0,texto.length-1);
				arrayMysArchivos = cadena.split(',');
				for(i=0;i<arrayMysArchivos.length;i++){
                $('#infoArchiv').html(''+arrayMysArchivos[i]+'');
            }
				obtenerElementos();
				document.location.href='../detalle_album.php?ID=<?php echo $_GET['ID']; ?>';
        },
        'displayData': 'speed'
    });
});
</script>
<script type="text/javascript">
	var texto = '';
	texto='<?php echo $_GET['ID']?>'+'/'+'<?php echo $url; ?>'+'/';
	var cadena = '';
	var arrayMysArchivos;
	function obtenerElementos() {
		EnviarDatos(arrayMysArchivos);
		return false;}
</script>