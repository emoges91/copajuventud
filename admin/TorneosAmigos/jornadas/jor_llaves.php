<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Face Llaves</title>
    <script src="../js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
</head>

<body>
<?php
include_once('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');

$cadena = "SELECT * FROM t_torneo WHERE ID=".$_GET['ID'];
$consulta_torneo= mysql_query($cadena, $conn);
$fila=mysql_fetch_assoc($consulta_torneo);


//consulta eventos fase de llave
$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=2";
$query_llave = mysql_query($sql_llave, $conn);
$row_llave=mysql_fetch_assoc($query_llave);

//consulta eventos fase de grupos
$sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query_grupo = mysql_query($sql_grupo, $conn);
$cant_grupos = mysql_num_rows($query_grupo);//cantidad de enventos en grupos
$row_grupo=mysql_fetch_assoc($query_grupo);

if($cant_grupos>0){
	//consulta para obtener la ultima jornada
	$sql_ultima_grupos="SELECT  MAX(t_jornadas.NUM_JOR) as UJORGRU, MAX(t_jornadas.NUM_JOR)as UGRUGRU  
								FROM t_jornadas
							WHERE t_jornadas.ID_EVE=".$row_grupo['ID'];
	$consulta_ultima_grupos = mysql_query($sql_ultima_grupos, $conn);
	$row_ultima_grupos=mysql_fetch_assoc($consulta_ultima_grupos);
}
else{
	$row_ultima_grupos['UJORGRU']=0;
	$row_ultima_grupos['UGRUGRU']=0;
}

//consulta para optener el ultimo grupo llaves
$sql_ultimo_llaves="SELECT  MAX(t_jornadas.GRUPO) as UGRULLA,MAX(t_jornadas.NUM_JOR) as  UJORLLA
							FROM t_jornadas
						WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
$consulta_ultimo_llaves = mysql_query($sql_ultimo_llaves, $conn);
$resultado_ultimo_llaves=mysql_fetch_assoc($consulta_ultimo_llaves);

// obtener las jornadas de llaves
$sql_total_partidos="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
$consulta_total_partidos = mysql_query($sql_total_partidos, $conn);
$cant_partidos = mysql_num_rows($consulta_total_partidos);

if(($cant_partidos>0)&&($fila['INSTANCIA'])>1){
	$dire='../';
	include_once('../mostrar_torneo.php');
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr bgcolor="#cacaca" >
		<td><?php echo $row_llave['NOMBRE'];?></td>					
		<td align="right" width="330px">
        	<input type="button" onclick="document.location.href='ingr_marca_llaves.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Ingresar Marcadores">
			<input type="button" onclick="document.location.href='partidos_pendientes_llaves.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Partidos Pendientes">
       	</td>
	</tr>
	<tr>
		<td>
        	<table cellpadding="0" cellspacing="0" class="jornadas">
<?php
	$jornada=$row_ultima_grupos['UJORGRU'];
	$indicador_final=0;
	while($jornada<$resultado_ultimo_llaves['UJORLLA']){
		$sql_partidos="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row_llave['ID']." AND t_jornadas.NUM_JOR=".($jornada+1).
				' ORDER BY t_jornadas.GRUPO ASC ';
		$consulta_partidos = mysql_query($sql_partidos, $conn);
		$cant_partidos_fase = mysql_num_rows($consulta_partidos);
		
		//etiqueta para mostrar si es final o semifinal
		$etiqueta='';
		if($cant_partidos_fase>2){
			$etiqueta='Fase de '.$cant_partidos_fase.'avos de Final';
		}
		else if($cant_partidos_fase==2){
			if($indicador_final<2){
				$indicador_final++;
				$etiqueta='Semifinales';
			}
			else{
				$etiqueta='Final y Tercer Lugar';
			}
		}
		else{
			$etiqueta='Final';
		}
		?>
        	<tr>
				<td colspan="11"  id="Blanco"  align="center">&ensp;</td>
			</tr>
			<tr>
				<td colspan="11" id="Blanco"><?php echo $etiqueta;?></td>
			</tr>
			<tr>
				<td colspan="10" id="Njornadas" align="center">Jornada <?php echo ($jornada+1);?></td>
                <td id="tdcancha" align="center">
                	<a href="ingr_cancha_fecha.php?NUM_JOR=<?php echo ($jornada+1);?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>&TIPO=2">
						<img src="../img/ico_cancha_hora.png" title="Asugnar a esta jornada cancha/fecha/hora"/>
					</a>
             	</td>
			</tr>
			<tr >
				<th></th>
                <th></th>
                <th>Equipo Casa</th>
                <th>Marcador</th>
                <th></th>
                <th>Equipo visita</th>
                <th>Marcador</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Jornada</th>
                <th style="border-right:1px solid #ddd;">Grupo</th>
			</tr>
		<?php	
		while($fila_equipos=mysql_fetch_assoc($consulta_partidos)){
			//-------------------mostrar cuanto el equipo esta libre---------
			if($fila_equipos['ID_EQUI_CAS']<>0){
				$str_query_equi_casa="SELECT * FROM t_equipo
					WHERE t_equipo.ID=".$fila_equipos['ID_EQUI_CAS'];
				$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
				$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
			}
			else{
				$fila_equipo_casa['NOMBRE']='LIBRE';
			}
				
			//-------------------mostrar cuanto el equipo esta libre---------
			if($fila_equipos['ID_EQUI_VIS']<>0){
				$str_query_equi_visita="SELECT * FROM t_equipo
					WHERE t_equipo.ID=".$fila_equipos['ID_EQUI_VIS'];
				$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
				$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
			}
			else{
				$fila_equipo_visita['NOMBRE']='LIBRE';
			}	
			
			//mostrar los marcadores casa con guion encasa de no haberlos jugado
			if($fila_equipos['MARCADOR_CASA']==''){
				$marcador_casa='-';
			}
			else{
				$marcador_casa=$fila_equipos['MARCADOR_CASA'];
			}
			
			//mostrar los marcadores visita con guion encasa de no haberlos jugado	
			if($fila_equipos['MARCADOR_VISITA']==''){
				$marcador_visita='-';
			}
			else{
				$marcador_visita=$fila_equipos['MARCADOR_VISITA'];
			}
	
			$estado_partido='';
			switch($fila_equipos['ESTADO']){
					case 0:$estado_partido='No jugado';
					break;
					case 1:$estado_partido='Pendiente';
					break;
					case 2:$estado_partido='Siguiente';
					break;
					case 3:$estado_partido='Jugado';
					break;
					case 4:$estado_partido='Anterior';
					break;
			}
			?>
			<tr>
				<td align="center">
                	<a href="editar_jornada.php?ID_JOR=<?php echo $fila_equipos['ID'];?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">
						<img src="../img/icono_editar.png" title="Editar"/>
					</a>
               	</td>
				<td align="center">
                	<a href="editar/voltear_llaves.php?ID_JOR=<?php echo $fila_equipos['ID'];?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>" onclick="javascript: return voltear();">
						<img src="../img/cambiar.png" title="Voltear" width="25px"/>
					</a>
				<td align="center"><?php echo $fila_equipo_casa['NOMBRE'];?></td>
				<td align="center"><?php echo $marcador_casa;?></td>
				<td align="center">Vrs</td>
				<td align="center"><?php echo $fila_equipo_visita['NOMBRE'];?></td>
				<td align="center"><?php echo $marcador_visita;?></td>
				<td align="center"><?php echo cambiaf_a_normal($fila_equipos['FECHA']);?></td>
				<td align="center"><?php echo $estado_partido;?></td>
				<td align="center"><?php echo $fila_equipos['NUM_JOR'];?></td>
				<td align="center"><?php echo $fila_equipos['GRUPO'];?></td>
			</tr>
        <?php
		}
		$jornada=($jornada+1);
	}
	?>
			</table>
		</td>
	</tr>
</table>
<?php
}
else{
	?>
	<script type="text/javascript">
		alert('Las jornadas en fase de llaves no se encuentran creadas');
		document.location.href='crear_fase_llaves.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>';
	</script>
<?php
}
?>
</body>
</html>