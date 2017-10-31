<?php
include('../../conexiones/conec_cookies.php');
$sql="SELECT * FROM T_CON_DIS_AMI WHERE ID=".$_GET['id']."";
$query=mysql_query($sql,$conn);

while($row=mysql_fetch_assoc($query))
{
?>
<form action="save_edit.php" method="post">
	<table align="center">
    <input type="hidden" name="id_torneo" value="<?php echo $_GET['id_torneo'];?>" />
    <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB'];?>" />
    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
    <tr>
     <td>Equipo:<input type="text" name="equipo" value="<?php echo $row['NOMBRE_EQUI'];?>" /></td>
     <td>Porcentaje:<input type="text" name="porcentaje" value="<?php echo $row['PORCENTAJE'] ?>"/></td>
    </tr>
    
    <tr>
     <td align="center">
     	<input type="submit" value="Guardar" />
     	<input type="button" value="Cancelar" 
        	onclick="document.location.href='ctrl_disc.php?ID=<?php echo $_GET['id_torneo'];?>&NOMB=<?php echo $_GET['NOMB'];?>';" />
   	</td>
    </tr>
    
    <tr>
    </tr>
    </table>
</form>

<?php
}
?>