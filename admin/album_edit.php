<?php
include('conexiones/conec_cookies.php');

$sAlbumID = (isset($_GET['ID'])) ? $_GET['ID'] : 0;

$sql = "SELECT * FROM t_albun WHERE ID = " . $sAlbumID . "";
$query = mysql_query($sql);
$dato = mysql_fetch_assoc($query);

include('sec/inc.head.php');
?>
<h1>Editar Album</h1>
<hr/>
<br/>
<form action="album_edit_save.php" method="post">
    <input type="hidden" name="ID" value="<?php echo $sAlbumID; ?>">
    <input type="hidden" name="pg" value="<?php echo 0; ?>">
    <table >
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="NOMBRE" value= "<?php echo $dato['NOMBRE']; ?>"></td>
        </tr>
        <tr>
            <td>Descripcion:</td>
            <td><input type="text" name="DIR" value= "<?php echo $dato['DESCRIP']; ?>"></td>
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" value="Cancelar" onclick="document.location.href = 'album.php';"/>
    </div> 
</form>

<?php
include('sec/inc.footer.php');
?>
