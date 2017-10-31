<?php
include('conexiones/conec_cookies.php');

$sql = "SELECT URL FROM t_albun WHERE ID='" . $_GET['ID'] . "'";
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);
$url = $row['URL'];

include('sec/inc.head.php');
?>
<link  rel="stylesheet" type="text/css" href="css/uploadify.css"/> 
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>



<h1>Agregar Imagenes</h1>
<hr/>
<br/>

<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'fotos.php?ID=<?php echo $_GET['ID']; ?>';" value="Volver"/> 
</div>
<div class="clear"></div>
<br/> 

<div id="fileQueue"></div>
<br/>
<input type="file" name="uploadify" id="uploadify"/>
<br/>
<p>
    <a href="javascript:$('#uploadify').uploadifyUpload();">Subir imagenes</a> | 
    <a href="javascript:$('#uploadify').uploadifyClearQueue();">Cancelar todo</a>
</p>


<script type="text/javascript">
        $(document).ready(function() {
            $("#uploadify").uploadify({
                'uploader': 'swf/uploadify.swf',
                'script': 'uploadify.php',
                'cancelImg': 'images/cancel.png',
                'folder': '<?php echo "original/" . $url; ?>',
                'queueID': 'fileQueue',
                'auto': false,
                'multi': true,
                'buttonText': 'Buscar',
                'fileDesc': 'Imagenes',
                'fileExt': '*.jpg; *.jpeg; *.gif; *.png;',
                'onComplete': function(event, a, b, response, data) {
                    texto = texto + '' + b.name + '/' + '';
                },
                'onAllComplete':
                        function(event, d) {
                            cadena = texto.substr(0, texto.length - 1);
                            arrayMysArchivos = cadena.split(',');
                            for (i = 0; i < arrayMysArchivos.length; i++) {
                                $('#infoArchiv').html('' + arrayMysArchivos[i] + '');
                            }
                            obtenerElementos();
                        },
                'displayData': 'speed'
            });
        });
</script>
<script type="text/javascript">
    var texto = '';
    texto = '<?php echo $_GET['ID'] ?>' + '/' + '<?php echo $url; ?>' + '/';
    var cadena = '';
    var arrayMysArchivos;
    function obtenerElementos() {
        EnviarDatos(arrayMysArchivos);
        return false;
    }
</script>
<?php
include('sec/inc.footer.php');
?>
