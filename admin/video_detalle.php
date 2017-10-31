<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$sql = "SELECT * FROM t_video WHERE ID = '" . $_GET['ID'] . "'";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);
?>
<h1>Editar Video</h1>
<hr>
<br/>
<form action="video_edit_save.php" method="post">
    <input type="hidden" name="ID" value="<?php echo $_GET['ID'] ?>">
    <table>
        <tr>
            <td>Nombre: </td>
            <td><input type="text" name="NOMBRE" value= "<?php echo $row['NOMBRE']; ?>"></td>

        </tr>
        <tr>
            <td>Descripcion: </td>
            <td><input type="text" name="DESCRIP" value="<?php echo $row['DESCRIP']; ?>"></td>
        </tr>
        <tr>
            <td>URL Youtube: </td>
            <td><input type="text" name="URL" value="<?php echo $row['URL']; ?>"></td>
        </tr> 
    </table>
      <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
       <input type="button" Value="Cancelar" onclick="document.location.href = 'videos.php';">
    </div>  
</form>

<?php
include('sec/inc.footer.php');
?>
