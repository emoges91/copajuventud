<?php 
include('../conexiones/conec_cookies.php');

$dire='../';
include_once('../mostrar_torneo.php');

$sql = "SELECT * FROM t_equipo WHERE ID = '".$_GET['ID_EQUI']."'";
$query = mysql_query($sql, $conn);

$row=mysql_fetch_assoc($query);
?>

<form name="formulario" action="editar/guardar_edit_equi.php" enctype="multipart/form-data" method="post">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
    <input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
    <input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
	<td colspan="2" align="center">Editar equipo</td>
</tr>
<tr>
	<input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
	<td>Nombre: *</td>
	<td><input type="text" name="nombre" value="<?php echo $row['NOMBRE']; ?>"></td>
</tr>
<tr>	
    <td colspan="2" align="right">
    	<input type="submit" Value="Guardar">
		<input type="button" Value="Cancelar" 
        onclick="document.location.href='mostrar_equipos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>';" >
	</td>
</tr>
</table>
</form>