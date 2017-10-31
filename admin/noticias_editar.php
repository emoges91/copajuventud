<?php
include('conexiones/conec_cookies.php');

$nNoticiaID = (isset($_GET['id'])) ? $_GET['id'] : '';

$sql = "SELECT * FROM t_noticias WHERE ID = '" . $nNoticiaID . "'";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);

$sFeatured = '';
if ($row['FEATURED'] == '1') {
    $sFeatured = 'checked="cheched"';
}

include('sec/inc.head.php');
?>
<h1>Editar Noticias</h1>
<hr/>
<br/>
<form action="noticias_editar_save.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table align="center">
        <tr>
            <td>Titulo*</td>
            <td><input type="text" name="TITULO" value= "<?php echo $row['TITULO']; ?>"></td>
        <input type="hidden" name="id" value="<?php echo $nNoticiaID; ?>">
        </tr>
        <tr>
            <td>Fecha:*</td>
            <td>
                <input name="FECHA" type="date" value="<?php echo $row['FECHA']; ?>"  autocomplete="off" size="19">  
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Descripcion corta*</td>
            <td><textarea name="DC" id="DC" cols="80" rows="5"><?php echo $row['DESCRIPCION_CORTA']; ?></textarea></td>
        </tr>
        <tr>
            <td>Fotografia:</td>
            <td><input type="file" name="foto"></td>
        </tr>
        <tr>
            <td>Destacada:*</td>
            <td><input type="checkbox" name="featured" value="1" <?php echo $sFeatured; ?>/></td>
        </tr>
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" Value="Cancelar" onclick="document.location.href = 'noticias.php';"/>
    </div>  

    <p>Los campos con asterisco(*)son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>
