<?php
include('conexiones/conec_cookies.php');


$sql = "SELECT * FROM t_patrocinador WHERE ID = '" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);

include('sec/inc.head.php');

$sMostrar_Check = '';
if ($row['MOSTRAR'] == '1') {
    $sMostrar_Check = "checked";
}
?>
<h1>Editar Patrocinador</h1>
<hr/>
<br/>
<form action="patrocinador_editar_save.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="borrar" value="<?php echo $row['EMPRESA']; ?>">
    <input type="hidden" name="bolean" value="<?php echo $row['URL']; ?>">
    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>" />
    <table >
        <tr>
            <td>Nombre*</td>
            <td><input type="text" name="empresa" value= "<?php echo $row['EMPRESA']; ?>"></td>
        </tr>
        <tr>
            <td>Direccion*</td>
            <td><input type="text" name="direccion" value= "<?php echo $row['DIRECCION']; ?>"></td>
        </tr>
        <tr>
            <td>Mostar:*</td>
            <td><input type="checkbox"  name="mostrar" <?php echo $sMostrar_Check; ?> value="1"></td>
        </tr>
        <tr>
            <td>Imagen</td>
            <td><input type="file" name="foto"></td>
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar">
        <input type="button" Value="Atras" onclick="document.location.href = './patrocinador.php';">
    </div>
    <p>Los campos con asterisco(*)son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>