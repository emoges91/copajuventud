<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$sql = "SELECT * FROM t_img WHERE ID='" . $_GET['ID'] . "'";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);
?>
<h1>Editar Foto</h1>
<hr/>
<br/>
<form action="foto_edit_save.php" method="post">
    <input type="hidden" name="ID" value=" <?php echo $row['ID'] ?>" />
    <input type="hidden" name="IDR" value="<?php echo $_GET['IDA'] ?>" />
    <input type="hidden" name="PAG" value="<?php echo $_GET['pg'] ?>"/>
    <table >
        <tr>
            <td>Nombre</td>
            <td><input type="text" name="NOMBRE" value= "<?php echo $row['NOMBRE']; ?>" /></td>
        </tr>
        <tr>
            <td>Descripcion</td>
            <td><input type="text" name="DESCRIP" value= "<?php echo $row['DESCRIP']; ?>" /></td>
        </tr>
        <tr>
            <td>Portada del album ?</td>
            <td><input type="checkbox" name="PORTADA"/></td>
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" value="Guardar" />
        <input type="button" Value="Cancelar" onclick="document.location.href = 'fotos.php?ID=<?php echo $_GET['IDA'] ?>&pg=<?php echo $_GET['pg'] ?>'" />
    </div> 
</form>
<?php
include('sec/inc.footer.php');
?>