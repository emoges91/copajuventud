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
	
echo'<form action="guardar_edit_amigos.php" method="post">
<table align="center">
	<tr>
		<td colspan="9" align="center">
			Torneo:<input type="text" name="nom_torneo" value="'.$fila_torneo_con['NOMBRE'].'">	
			<input type="hidden" name="info" value="'.$fila_torneo_con['ID'].'/'.$fila_torneo_con['CANT'].'">		
			</td>
	</tr>
	<tr>
		<td colspan="9" align="center">
			Estado:
			<input type="checkbox" '.$var_estado.' name="estado" value="1"/>
		</td>
	</tr>
	<tr>
		<td colspan="9">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Tabla</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Equipo</td>
		<td>PJ</td>
		<td>PG</td>
		<td>PE</td>
		<td>PP</td>
		<td>GA</td>
		<td>GR</td>
		<td>PTS</td>
	</tr>';
$i=0;	
while($fila_est=mysql_fetch_assoc($query_est)){
	$i++;
		echo'	
	<tr>
		<td>'.$i.'<input type="hidden" name="id_est'.$i.'" maxlength="2" size="2px" value="'.$fila_est['ID'].'"></td>
		<td><input type="text" name="nom_equi'.$i.'" maxlength="60" size="36px" value="'.$fila_est['EQUIPO'].'"></td>
		<td><input type="text" name="pj'.$i.'" maxlength="2" size="2px" value="'.$fila_est['PJ'].'"></td>
		<td><input type="text" name="pg'.$i.'" maxlength="2" size="2px" value="'.$fila_est['PG'].'"></td>
		<td><input type="text" name="pe'.$i.'" maxlength="2" size="2px" value="'.$fila_est['PE'].'"></td>
		<td><input type="text" name="pp'.$i.'" maxlength="2" size="2px" value="'.$fila_est['PP'].'"></td>
		<td><input type="text" name="ga'.$i.'" maxlength="2" size="2px" value="'.$fila_est['GA'].'"></td>
		<td><input type="text" name="gr'.$i.'" maxlength="2" size="2px" value="'.$fila_est['GR'].'"></td>
		<td><input type="text" name="pts'.$i.'" maxlength="2" size="2px" value="'.$fila_est['PTS'].'"></td>
	</tr>';
}
echo '
<tr>
	<td colspan="9">&nbsp;</td>
</tr>
</table>';

echo '
<table align="center">
	<tr>
		<td colspan="6" align="center">Jornadas</td>
	</tr>
	<tr>
		<td>Equipos casa</td>
		<td>Marcador</td>
		<td></td>
		<td>Equipo visita</td>
		<td>Marcador</td>
		<td>Fecha</td>
	</tr>
';

$i=0;
while($fila_jor=mysql_fetch_assoc($query_jor)){
$i++;	
	echo'
	<tr><input type="hidden" name="id_jor'.$i.'" maxlength="2" size="2px" value="'.$fila_jor['ID'].'">
		<td><input type="text" name="equipo_casa'.$i.'" maxlength="60" value="'.$fila_jor['EQUI_CASA'].'"></td>
		<td><input type="text" name="marc_casa'.$i.'" maxlength="2" size="6px" value="'.$fila_jor['MARC_CASA'].'"></td>
		<td>Vrs</td>
		<td><input type="text" name="equipo_vis'.$i.'" maxlength="60" value="'.$fila_jor['EQUI_VIS'].'"></td>
		<td><input type="text" name="marc_vis'.$i.'"  maxlength="2" size="6px" value="'.$fila_jor['MARC_VIS'].'"></td>
		<td><input type="text" name="fecha'.$i.'" value="'.cambiaf_a_normal($fila_jor['FECHA']).'" onclick="displayDatePicker(\'fecha'.$i.'\',this);" maxlength="8" size="8px"></td>
	</tr>
	';
}
echo'	
</table>
<table align="center">
	<tr align="right">
		<td><input type="submit" value="Guardar"></td>
		<td><input type="button" value="Cancelar" onclick="document.location.href=\'torneos_amigos.php\';"></td>
	</tr>
</table>
</form>';
?>