<link rel="stylesheet" type="text/css" href="time/anytime.css" />
<script type="text/javascript" src="time/jquery.js "></script>
<script type="text/javascript" src="time/anytime.js"></script>
<script src="script_piker/picker.js" type="text/javascript" charset="utf-8"></script>	
<link rel="stylesheet" href="script_piker/piker.css" type="text/css" media="screen" charset="utf-8" /> 
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<style type="text/css">
	.time { background-image:url("time/clock.png");
        background-position:right center; background-repeat:no-repeat;
        border:1px solid #FFC030;color:#3090C0;font-weight:bold}
</style>
<?php
include('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');

$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." ORDER BY ID";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);

$i=0;
$predicado="(";
while($row_even=mysql_fetch_assoc($query)){
	if($i!=0){
		$predicado=$predicado." OR ";
	}
	
	
	if($row_even['TIPO']==1){
		$predicado=$predicado." ID_EVE =".$row_even['ID'];
		$grupos_eve=$row_even['ID'];
	}
	
	
	
	if($row_even['TIPO']==2){
		$predicado=$predicado." ID_EVE =".$row_even['ID'];
		$llaves_eve=$row_even['ID'];
	}
	
	
	$i++;
}
$predicado=$predicado.")";

//consultar los partidos de la fecha consultada
$cadena_equi="SELECT * FROM t_jornadas
				WHERE ".$predicado." AND NUM_JOR=".$_GET['NUM_JOR']."
				ORDER BY t_jornadas.ID_EVE ASC,t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ";
$consulta_total_jornadas = mysql_query($cadena_equi, $conn);
$cant_jor = mysql_num_rows($consulta_total_jornadas);
?>
<form action="guardar/guardar_cancha_fecha.php" method="post">
<input name="HidNumJor" type="hidden" value="<?php echo $_GET['NUM_JOR']; ?>" />
<input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
<input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
<input name="HidTipo" type="hidden" value="<?php echo $_GET['TIPO']; ?>" />
<table cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#cacaca">
		<td colspan="8">Asinar cancha, fecha y hora a la jornada</td>
		<td align="right">
        	<input type="submit"  value="Guardar">
            <?php
			if($_GET['TIPO']==1){
				$destino="document.location.href='jor_grupos.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';";
			}
			else{
				$destino="document.location.href='jor_llaves.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';";
			}
			?>
            <input type="button" value="Cancelar" onClick="<?php echo $destino;?>"/>
       	</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" class="jornadas" style="margin-top:30px;">
    <tr>
		<td colspan="9" align="center" id="Njornadas">
			Jornada <?php echo $_GET['NUM_JOR'];?>
		</td>
	</tr>
    <tr>
		<th>Equipo Casa</th>
		<th></th>
		<th>Equipo visita</th>
		<th>Fecha</th>
		<th>Hora</th>
		<th>Estado</th>
		<th>Jornada</th>
		<th>Grupo</th>
		<th style="border-right:1px solid #ddd;">Cancha</th>
	</tr>
<?php
if(($cant_jor>0)){
	$contador_partidos=0;
	$flag_jornada_sin_equipos=0;
	while($total_jornadas=mysql_fetch_assoc($consulta_total_jornadas)){
		$contador_partidos++;						
		$bloquear_marcador=0;		
		//-------------------mostrar cuanto el equipo esta libre---------
		if($total_jornadas['ID_EQUI_CAS']<>0){
			$str_query_equi_casa="SELECT * FROM t_equipo
				WHERE t_equipo.ID=".$total_jornadas['ID_EQUI_CAS'];
			$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
			$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
			
			$flag_jornada_sin_equipos=1;
		}
		else{
			$fila_equipo_casa['NOMBRE']='LIBRE';
			$bloquear_marcador=1;
		}
				
		//-------------------mostrar cuanto el equipo esta libre---------
		if($total_jornadas['ID_EQUI_VIS']<>0){
			$str_query_equi_visita="SELECT * FROM t_equipo
				WHERE t_equipo.ID=".$total_jornadas['ID_EQUI_VIS'];
			$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
			$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
			
			$flag_jornada_sin_equipos=1;
		}
		else{
			$fila_equipo_visita['NOMBRE']='LIBRE';
			$bloquear_marcador=1;
		}
		
		$estado_partido='';
		switch($total_jornadas['ESTADO']){
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
		
		if($bloquear_marcador==1){
			$habilitado=' style="background:#F7E9B9;"';//disabled="disabled"
			$horaClass="";
		}
		else{
			$habilitado="";
			$horaClass="time";							
		}
		
		if($total_jornadas['FECHA']!=''){
			$fecha=cambiaf_a_normal($total_jornadas['FECHA']);
		}
		else{
			$fecha='';
		}
		?>
		<tr>
        	<input type="hidden" name="hdn_idPartido<?php echo $contador_partidos;?>" value="<?php echo $total_jornadas['ID'];?>">
			<td align="center"><?php echo $fila_equipo_casa['NOMBRE'];?></td>
			<td align="center">Vrs</td>
			<td align="center"><?php echo $fila_equipo_visita['NOMBRE'];?></td>
			<td align="center">
                <input name="piker_<?php echo $contador_partidos;?>" size="8px"  type="text"
                onclick="displayDatePicker('piker_<?php echo $contador_partidos;?>',this);" 
                value="<?php echo $fecha;?>" <?php echo $habilitado;?> >
                &ensp;
           	</td>
			<td align="center">
				<input type="text" maxlength="5" <?php echo $horaClass;?> id="field<?php echo $contador_partidos;?>" 
                size="8px" name="TXT_hora<?php echo $contador_partidos;?>" value="<?php echo $total_jornadas['HORA'];?>" <?php echo $habilitado;?>>
				&ensp;
            </td>
			<td align="center"><?php echo $estado_partido;?></td>
			<td align="center"><?php echo $total_jornadas['NUM_JOR'];?></td>
			<td align="center"><?php echo $total_jornadas['GRUPO'];?></td>
			<td align="center" style="border-right:1px solid #ddd;">
				<input  type="text" maxlength="100"  name="TXT_cancha<?php echo $contador_partidos;?>" 
                value="<?php echo $total_jornadas['CANCHA'];?>" <?php echo $habilitado;?> >
				&ensp;
           	</td>
            <script type="text/javascript">
  				$("#field<?php echo $contador_partidos;?>").AnyTime_picker(
      			{ format: "%H:%i", labelTitle: "Hora",
        		labelHour: "Hora", labelMinute: "Minuto" } );
			</script>
		</tr>
        <?php
		$comparar_jornadas=$total_jornadas['NUM_JOR'];
	}

}
else{
	echo "<script type=\"text/javascript\">
		alert('Las jornadas no se han creado.');
	</script>";
}
?>
<input type="hidden" name="total_partidos" value="<?php echo $contador_partidos;?>">
</table>
</form>