<style type="text/css">
.puntero{
 Cursor : pointer;

}
</style>
<script>
function mouse_arriba(elemento){
	
	var trElemnto=document.getElementById(elemento);
	elemento.bgColor="#FFee88";
}
function mouse_fuera(elemento){
	
	var trElemnto=document.getElementById(elemento);
	elemento.bgColor="";
}
</script>
<?php
include('../conexiones/conec_cookies.php');
?>
<table width="100%" border="0" bgcolor="darkgray">
	<tr>
		<td><a href="../index.php">Pagina principal</a></td>
    </tr>
</table>
<table align="center">
	<tr>
		<td>&ensp;Crear torneos Amigos&ensp;</td>
	</tr>
</table>

<form action="crear_tor_amig.php" method="post">
<table align="center">
	<tr>
    	<td>Nombre :</td>
        <td colspan="2"><input type="text" name="nombre"  /></td>
    </tr>
    <tr>
    	<td>Cantidad de equipos: </td>
        <td colspan="2"><input type="text" name="cant_equi" maxlength="2" /></td>
    </tr>
    <tr>
    	<td>Estado :</td>
        <td colspan="2"><input type="checkbox" checked="checked" name="estado" value="1"/></td>
    </tr>
    <tr>
    	<td colspan="3" align="center">
        	<input type="submit" value="Crear" />
      		<input type="reset" value="Limpiar" />
       	</td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

<table align="center" cellpadding="0" cellspacing="0">
	<tr align="center" >
    	<td colspan="4">&ensp;Torneos Amigos&ensp;</td>
    </tr>
    <tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr  bgcolor="#017cd1">
    	<td align="center">Num.</td>
    	<td align="center">&ensp;Acciones&ensp;</td>
    	<td align="center">&ensp;Nombre&ensp;</td>
        <td align="center">&ensp;Cantidad Equipos&ensp;</td>
        <td align="center">&ensp;Estado&ensp;</td>
    </tr>
<?php
	$sql_torneo_cons="SELECT * FROM t_tor_amigo ";
	$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);
	
	$i=0;
	while($fila_torneo_con=mysql_fetch_assoc($query_torneo_cons)){
		$i++;
		if($fila_torneo_con['ESTADO']==1){
			$estado="Activo";
		}
		else{
			$estado="Inactivo";
		}
		
	echo '    
    <tr  class="puntero" onclick="document.location.href=\'ver_amigos.php?id='.$fila_torneo_con['ID'].'\'" onmouseover="mouse_arriba(this);" onmouseout="mouse_fuera(this);">
		<td>&ensp;'.$i.'&ensp;</td>
		<td>
			&ensp;<a href="eliminar_amigos.php?id='.$fila_torneo_con['ID'].'" onclick="javascript: return sure();">Eliminar</a>
			|| <a href="editar_amigos.php?id='.$fila_torneo_con['ID'].'">Editar</a>&ensp;
		</td>
    	<td>&ensp;'.$fila_torneo_con['NOMBRE'].'&ensp;</td>
		<td>&ensp;'.$fila_torneo_con['CANT'].'&ensp;</td>
		<td>&ensp;'.$estado.'&ensp;</td>
    </tr>';
	
	}
?>
</table>
