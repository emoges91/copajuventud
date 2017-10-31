<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include_once('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');


//seleccionar la jornada con el id correspondiente
$sql_jornada="SELECT * FROM t_jornadas WHERE ID=".$_GET['ID_JOR'];
$consulta_jornada=mysql_query($sql_jornada,$conn);
$fila_jornada=mysql_fetch_assoc($consulta_jornada);

//seleccionar el evento correspondiente
$sql_evento="SELECT * FROM t_eventos WHERE ID=".$fila_jornada['ID_EVE'];
$consulta_evento=mysql_query($sql_evento,$conn);
$fila_evento=mysql_fetch_assoc($consulta_evento);

$bandera_libres=0;

//-------------------mostrar cuanto el equipo esta libre---------
if($fila_jornada['ID_EQUI_CAS']<>0){
	//consultar el equipo casa
	$str_query_equi_casa="SELECT * FROM t_equipo
		WHERE t_equipo.ID=".$fila_jornada['ID_EQUI_CAS'];
	$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
	$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
}
else{
	$fila_equipo_casa['NOMBRE']='LIBRE';
	$bandera_libres=1;
}
				
//-------------------mostrar cuanto el equipo esta libre---------
if($fila_jornada['ID_EQUI_VIS']<>0){
	//consultar el equipo visita
	$str_query_equi_visita="SELECT * FROM t_equipo
		WHERE t_equipo.ID=".$fila_jornada['ID_EQUI_VIS'];
	$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
	$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
}
else{
	$fila_equipo_visita['NOMBRE']='LIBRE';
	$bandera_libres=1;
}

//setear  marcadores casa en nada
if($fila_jornada['MARCADOR_CASA']==''){
	$marcador_casa='-';
}
else{
	$marcador_casa=$fila_jornada['MARCADOR_CASA'];
}

//setear  marcadores visita en nada		
if($fila_jornada['MARCADOR_VISITA']==''){
	$marcador_visita='-';
}
else{
	$marcador_visita=$fila_jornada['MARCADOR_VISITA'];
}

//determinar el estado de la jornada
$estado_partido='';
switch($fila_jornada['ESTADO']){
	case 0:$estado_partido='No jugado';
		break;
	case 1:$estado_partido='pendiente';
		break;
	case 2:$estado_partido='Siguiente';
		break;
	case 3:$estado_partido='Jugado';
		break;
	case 4:$estado_partido='Anterior';
		break;
}
?>

<form action="editar/guardar_editar_jornada.php" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<td><?php echo $fila_evento['NOMBRE'];?></td>
        <td colspan="9" align="right">
        	<input type="submit" value="Guardar">
            <?php
            if($fila_evento['TIPO']==1){
				echo '<input type="button" value="Cancelar" onclick="document.location.href=\'jor_grupos.php?ID='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'\';"/>';
            }
			else{
				echo '<input type="button" value="Cancelar" onclick="document.location.href=\'jor_llaves.php?ID='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'\';"/>';
			}
			?>
            
       	</td>
	</tr>
</table>
<table class="jornadas" cellpadding="0" cellspacing="0">
	<tr  align="center">
		<th>Equipo casa</th>
		<th>Marcador</th>
		<th></th>
		<th>Equipo visita</th>
		<th>Marcador</th>
		<th>Fecha</th>
		<th>Estado</th>
		<th>Jornada</th>
		<th style="border-right:1px solid #ddd;">Grupo</th>
	</tr>
	<tr>
		<td align="center"><?php echo $fila_equipo_casa['NOMBRE'];?></td>
		<td align="center" ><?php echo $marcador_casa;?>
			<input type="hidden" name="hdn_marcadorCasa_viejo" value="<?php echo $marcador_casa;?>">
		</td>
		<td align="center" >Vrs</td>
		<td align="center" ><?php echo $fila_equipo_visita['NOMBRE'];?></td>
		<td align="center" >
			<?php echo $marcador_visita;?>
			<input type="hidden" name="hdn_marcadorVisita_viejo" value="<?php echo $marcador_visita;?>"></td>
		<td align="center" ><?php echo cambiaf_a_normal($fila_jornada['FECHA']);?></td>
		<td align="center" ><?php echo $estado_partido;?></td>
		<td align="center" ><?php echo $fila_jornada['NUM_JOR'];?></td>
		<td align="center" style="border-right:1px solid #ddd;"><?php echo $fila_jornada['GRUPO'];?></td>
	</tr>
	<?php
	if($bandera_libres==0){?>
	<tr>
		<input type="hidden" name="hdn_id" value="<?php echo $fila_jornada['ID'];?>"/>
		<input type="hidden" name="hdn_estado" value="<?php echo $fila_jornada['ESTADO'];?>"/>
		<input type="hidden" name="hdn_tipo" value="<?php echo $fila_evento['TIPO'];?>"/>
		<input type="hidden" name="hdn_id_troneo" value="<?php echo $_GET['ID'];?>"/>
        <input type="hidden" name="hdn_nomb_troneo" value="<?php echo $_GET['NOMB'];?>"/> 
        
		<td><input type="hidden" name="hdn_id_casa" value="<?php echo $fila_jornada['ID_EQUI_CAS'];?>"/>&ensp;</td>
		<td><input type="text" maxlength="2" size="8px" name="TXT_marcadorCasa_nuevo" value=""/></td>
		<td>Vrs</td>
		<td><input type="hidden" name="hdn_id_vis" value="<?php echo $fila_jornada['ID_EQUI_VIS'];?>"/>&ensp;</td>
		<td><input type="text" maxlength="2" size="8px" name="TXT_marcadorVisita_nuevo" value=""/></td>
		<td colspan="4" style="border-right:1px solid #ddd;">&ensp;</td>
	</tr>
</table>
</form>
<?php
	}
?>