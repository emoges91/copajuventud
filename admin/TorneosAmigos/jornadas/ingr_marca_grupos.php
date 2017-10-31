<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');

//obtener el evento----------------------------------------------------------
$sql_eve_llaves = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." AND TIPO=2";
$query_eve_llaves = mysql_query($sql_eve_llaves, $conn);
$row_eve_llaves=mysql_fetch_assoc($query_eve_llaves);

//consultar las jornadas----------------------------------------------------------
$str_jor_llaves="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row_eve_llaves['ID'];
$consulta_jor_llaves = mysql_query($str_jor_llaves, $conn);
$cant_jor_llaves = mysql_num_rows($consulta_jor_llaves);

//*******************************************************************************************8

//obtener el evento----------------------------------------------------------
$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." AND TIPO=1";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
$row=mysql_fetch_assoc($query);

//consultar las jornadas----------------------------------------------------------
$cadena_equi="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row['ID'].' AND t_jornadas.ESTADO=2 
				ORDER BY t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ';
$consulta_total_jornadas = mysql_query($cadena_equi, $conn);
$cant_jor = mysql_num_rows($consulta_total_jornadas);
?>
<form action="guardar/guardar_igre_marca_grupos.php" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr bgcolor="#cacaca">
		<td>Ingresar Marcadores <?php echo $row['NOMBRE'];?></td>
        <td align="right">
        	<input type="submit"  value="Guardar">
            	<input type="button" onclick="document.location.href='jor_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Cancelar"> 
      	</td>
	</tr>
	<tr>
    	<td colspan="2">
            <input type="hidden" name="id_torneo" value="<?php echo $_GET['ID'];?>"/>
            <input type="hidden" name="nomb_torneo" value="<?php echo $_GET['NOMB'];?>"/>
            <table class="jornadas" ellpadding="0" cellspacing="0">
<?php
// si existen jornadas en estado siguiente--------------------------------------------
if($cant_jor>0){
	//recorrer las jornadas---------------------------------------------------------
	$contador_partidos=0;
	while($total_jornadas=mysql_fetch_assoc($consulta_total_jornadas)){
		$contador_partidos++;			
		//--------------------mostrar la jornada----------
		if($total_jornadas['NUM_JOR']<>$comparar_jornadas){
?>
            <tr>
				<td colspan="10"  id="Blanco"  align="center">&ensp;</td>
			</tr>
			<tr>
				<td colspan="10" align="center" id="Njornadas" style="border-right:1px solid #ddd;">
					Jornada <?php echo $total_jornadas['NUM_JOR'];?>
					<input type="hidden" name="Hdn_jornadaActual" value="<?php echo $total_jornadas['NUM_JOR'].'/'.$row['ID'];?>">
				</td>
			</tr>
			<tr>
				<th></th>
				<th>Equipo Casa</th>
				<th>Marcador</th>
				<th></th>
				<th>Equipo visita</th>
				<th>Marcador</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th>Jornada</th>
				<th>Grupo</th>
			</tr>
        <?php
		}//fin if para mostrar encabezado jornadas
			
		$bloquear_marcador=0;		
		//-------------------mostrar cuanto el equipo esta libre---------
		if($total_jornadas['ID_EQUI_CAS']<>0){
			//obtener datos del equipo casa
			$str_query_equi_casa="SELECT * FROM t_equipo
				WHERE t_equipo.ID=".$total_jornadas['ID_EQUI_CAS'];
			$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
			$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
		}
		else{
			$fila_equipo_casa['NOMBRE']='LIBRE';
			$bloquear_marcador=1;
		}
				
		//-------------------mostrar cuanto el equipo esta libre---------
		if($total_jornadas['ID_EQUI_VIS']<>0){
			//obtener datos del equipo visita
			$str_query_equi_visita="SELECT * FROM t_equipo
				WHERE t_equipo.ID=".$total_jornadas['ID_EQUI_VIS'];
			$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
			$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
		}
		else{
			$fila_equipo_visita['NOMBRE']='LIBRE';
			$bloquear_marcador=1;
		}
		
		//consultar el estado de cada partido
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
		
		$tipo='';
		$Chbox='';
		//bloquer que digiten marcadores si un equipo esta libre
		if($bloquear_marcador==1){
			$tipo='hidden';	
			$Chbox='  type="hidden" value="on" ';		
		}
		else{//si no mostrar cuadros de texto y checks
			$tipo='text';	
			$Chbox=' type="checkbox"   checked="checked" ';			
		}
		?>
			<tr>
				<td align="center">
					<input name="CHK_partidos<?php echo $contador_partidos;?>"  <?php echo $Chbox;?>/>
					<input type="hidden" name="hdn_idPartido<?php echo $contador_partidos;?>" value="<?php echo $total_jornadas['ID'];?>">
				</td>
				<td align="center"><?php echo $fila_equipo_casa['NOMBRE'];?></td>
				<td align="center">
					<input type="<?php echo $tipo;?>" maxlength="2" size="8px" name="TXT_marcadorCasa<?php echo $contador_partidos;?>">
				</td>
				<td align="center">Vrs</td>
				<td align="center"><?php echo $fila_equipo_visita['NOMBRE'];?></td>
				<td align="center">
					<input type="<?php echo $tipo;?>" maxlength="2" size="8px" name="TXT_marcadorVisita<?php echo $contador_partidos;?>">
				</td>
				<td align="center"><?php echo cambiaf_a_normal($total_jornadas['FECHA']);?></td>
				<td align="center"><?php echo $estado_partido;?></td>
				<td align="center"><?php echo $total_jornadas['NUM_JOR'];?></td>
				<td align="center"><?php echo $total_jornadas['GRUPO'];?></td>
		</tr>
	<?php
		$comparar_jornadas=$total_jornadas['NUM_JOR'];
	}//fin ciclo while
	?>			
    <input type="hidden" name="total_partidos" value="<?php echo $contador_partidos;?>">
	</table>
</td>
<?php
}
else{
	if($cant_jor_llaves==0){
		echo "<script type=\"text/javascript\">
				alert('Las jornadas no se encuentran creadas ');
				document.location.href='crear_fase_llaves.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';
		</script>";
	}
	else{
		echo "<script type=\"text/javascript\">
			alert('Las jornadas de fase de llaves se encuentran creadas');
			document.location.href='jor_llaves.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';
		</script>";

	}
}
?>
	</tr>
</table>
</form>
