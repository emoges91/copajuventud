<link rel="stylesheet" href="../jornadas/css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php 
include("../conexiones/conec_cookies.php"); 

$dire='../';
include_once('../mostrar_torneo.php');

$sql = "SELECT * FROM t_est_equi
		LEFT JOIN t_equipo ON t_est_equi.ID_EQUI=t_equipo.ID
		WHERE ID_TORNEO=".$_GET['ID'];
$query = mysql_query($sql,$conn) or die (mysql_error());//habia error porq puso variable $bd y era $base_de_datos
?>
<table class="jornadas"  cellpadding="0" cellspacing="0">
	<tr>	
		<th></th>
		<th style="border-right:1px solid #ddd;">Equipo</th>
	</tr>
<?php
while($equipos=mysql_fetch_assoc($query)){
?>
	<tr>
		<td align="center">
			<a href="editar_equipo.php?ID_EQUI=<?php echo $equipos['ID'].'&ID='.$_GET['ID'].'&NOMB='.$_GET['NOMB'];?>">
				<img src="../img/modificar.png" title="Modificar" width="25px"/>
			</a>
		</td>
		<td style="border-right:1px solid #ddd;"><?php echo $equipos['NOMBRE'];?></td>	
	</tr>
<?php
}
?>
</table>