<?php
include('../conexiones/conec_cookies.php');

function cambiaf_a_normal($fecha){
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	return $lafecha;
}

//consultar el torneo recien creado
$sql_torneo_cons="SELECT * FROM t_tor_amigo
				WHERE ID=". $_GET['id'];				
$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);
$fila_torneo_con=mysql_fetch_assoc($query_torneo_cons);

$sql_est="SELECT * FROM t_est_amigos 
			WHERE ID_TORNEO=".$fila_torneo_con['ID'];
$query_est=mysql_query($sql_est, $conn);

$sql_jor="SELECT * FROM t_jor_amigos
		WHERE ID_TORNEO=".$fila_torneo_con['ID'];
$query_jor=mysql_query($sql_jor, $conn);

if($fila_torneo_con['ESTADO']==1){
	$var_estado='checked';
}

if($fila_torneo_con['ESTADO']==1){
	$estado="Activo";
}
else{
	$estado="Inactivo";
}
	
echo'
<table width="100%" border="0" bgcolor="darkgray">
	<tr>
		<td><a href="torneos_amigos.php">Torneos amigos</a>
        </td>
    </tr>
</table>
<table align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="9" align="center">
			&ensp;Torneo:'.$fila_torneo_con['NOMBRE'].'&ensp;			
			</td>
	</tr>
	<tr>
		<td colspan="9" align="center">
			&ensp;Estado: '.$estado.'&ensp;
		</td>
	</tr>
	<tr>
		<td colspan="9">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="9" align="center">&ensp;Tabla&ensp;</td>
	</tr>
	<tr bgcolor="#017cd1">
		<td colspan="2" align="center">&ensp;Equipo&ensp;</td>
		<td>&ensp;PJ&ensp;</td>
		<td>&ensp;PG&ensp;</td>
		<td>&ensp;PE&ensp;</td>
		<td>&ensp;PP&ensp;</td>
		<td>&ensp;GA&ensp;</td>
		<td>&ensp;GR&ensp;</td>
		<td>&ensp;PTS&ensp;</td>
	</tr>';
$i=0;	
while($fila_est=mysql_fetch_assoc($query_est)){
	$i++;
		echo'	
	<tr>
		<td>&ensp;'.$i.'&ensp;</td>
		<td>&ensp;'.$fila_est['EQUIPO'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PJ'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PG'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PE'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PP'].'&ensp;</td>
		<td>&ensp;'.$fila_est['GA'].'&ensp;</td>
		<td>&ensp;'.$fila_est['GR'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PTS'].'&ensp;</td>
	</tr>';
}
echo '
<tr>
	<td colspan="9">&nbsp;</td>
</tr>
</table>';

echo '
<table align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="6" align="center">Jornadas</td>
	</tr>
	<tr bgcolor="#017cd1">
		<td>&ensp;Equipos casa&ensp;</td>
		<td>&ensp;Marcador&ensp;</td>
		<td></td>
		<td>&ensp;Equipo visita&ensp;</td>
		<td>&ensp;Marcador&ensp;</td>
		<td>&ensp;Fecha&ensp;</td>
	</tr>
';

$i=0;
while($fila_jor=mysql_fetch_assoc($query_jor)){
$i++;	
	echo'
	<tr>
		<td>&ensp;'.$fila_jor['EQUI_CASA'].'&ensp;</td>
		<td>&ensp;'.$fila_jor['MARC_CASA'].'&ensp;</td>
		<td>Vrs</td>
		<td>&ensp;'.$fila_jor['EQUI_VIS'].'&ensp;</td>
		<td>&ensp;'.$fila_jor['MARC_VIS'].'&ensp;</td>
		<td>&ensp;'.cambiaf_a_normal($fila_jor['FECHA']).'&ensp;</td>
	</tr>
	';
}
echo'	
</table>';
?>