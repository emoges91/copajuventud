<?PHP
include ('conexiones/conec_cookies.php');


$nTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '';

$dToday = date('Y-m-d');

$sTitulo = '';
switch ($nTipo) {
    case '1':
        $sTitulo = 'Reglamento';
        break;
    case '2':
        $sTitulo = 'Comite Disciplinario';
        break;
    case '3':
        $sTitulo = 'Comite Competencia';
        break;
    case '4':
        $sTitulo = 'Otros Documentos';
        break;
    case '6':
        $sTitulo = 'Informes Arbitrales';
        break;
    case '7':
        $sTitulo = 'Revision Arbitral';
        break;
    case '5':
        $sTitulo = 'Costo de Arbitraje';
        break;
}
include('sec/inc.head.php'); 
?>
<h1>Agregar <?php echo $sTitulo; ?></h1>
<hr>
<br/>

<form name="Documentos" action="doc_save.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="tipo" value="<?php echo $nTipo; ?>"/>
    <table border="0" >
        <tr>
            <td>Asunto:* </td>
            <td><input type="text" name="asunto"></td>
        </tr>
        <tr>
            <td>Fecha:* </td>
            <td> 
                <input name="fecha" type="date" value="<?php echo $dToday; ?>"  autocomplete="off" size="19"> 
            </td>
        </tr>
        <tr>
            <td>Documento: </td>
            <td><input type="file" name="doc"></td>
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar">
        <input type="button" Value="Atras" onclick="document.location.href = 'doc.php?tipo=<?php echo $nTipo; ?>';">
    </div>
    <p>Los campos con asterisco (*) son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>
