<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include('../conexiones/conec_cookies.php');

$dire='../';
include_once('../mostrar_torneo.php');
	
//consulta grupos
$str_grupos="SELECT ID FROM t_eventos 
			WHERE TIPO=1 AND ID_TORNEO=".$_GET['ID'];
$query_grupos=mysql_query($str_grupos, $conn);
$cant_eve_grupos=mysql_num_rows($query_grupos);
$fila_grupos= mysql_fetch_assoc($query_grupos);

if($cant_eve_grupos==0){
	$fila_grupos['ID']=0;
}
				
//consulta llaves
$str_llaves="SELECT ID FROM t_eventos 
			WHERE TIPO=2 AND ID_TORNEO=".$_GET['ID'];
$query_llaves=mysql_query($str_llaves, $conn);
$fila_llaves= mysql_fetch_assoc($query_llaves);
				
$condicion_query=" WHERE ((ID_EVE=".$fila_grupos['ID'].") OR (ID_EVE=".$fila_llaves['ID'].")) 
and ((t_jornadas.ESTADO=4) OR (t_jornadas.ESTADO=3))";
	
//consultar el maximo de jornadas
$cadena_max_jor = "SELECT MAX(NUM_JOR) FROM t_jornadas ".$condicion_query;
$consulta_max_jor= mysql_query($cadena_max_jor, $conn);
$fila_max_jor=mysql_fetch_assoc($consulta_max_jor);
		
//consultar los equipo con los goles por jornada
$cadena_equipos = "SELECT *,	
			IF (t_jornadas.ID_EQUI_CAS<>t_equipo.ID,
			IFNULL(t_jornadas.MARCADOR_CASA,0),
			IFNULL(t_jornadas.MARCADOR_VISITA,0))AS TOTAL_JOR,
			t_equipo.ID AS ID_EQUI  
		FROM  t_equipo
		LEFT JOIN t_jornadas ON (t_equipo.ID=t_jornadas.ID_EQUI_CAS) OR (t_equipo.ID=t_jornadas.ID_EQUI_VIS)
		".$condicion_query."
		ORDER BY t_equipo.ID ASC,t_jornadas.NUM_JOR ASC";
$consulta_equipos= mysql_query($cadena_equipos, $conn);
$cant_jornadas = mysql_num_rows($consulta_equipos);

if($cant_jornadas>0){
	//**********************************recorrer la consulta y guardar los equipos en un array y ordenarlos********************************88										
	$id_actual=0;
	$equipos=null;
	$fila=-1;
	$columna=0;
	$acumulador=0;
	$contadorNegativo=0;
	//recorrer las filas de la consulta
	while($fila_equipos=mysql_fetch_assoc($consulta_equipos)){				
		//condicion para evaluar si la siguiente columna el id del equipo es el mismo
		if($fila_equipos['ID_EQUI']==$id_actual){
			$equipos[$fila][$contador]=$fila_equipos['TOTAL_JOR'];
			$acumulador=$acumulador+$fila_equipos['TOTAL_JOR'];
			$contador++;
			$contadorNegativo++;
		}
		else{
			$equipos[$fila+1][0] = $fila_equipos['NOMBRE'];
			$equipos[$fila+1][1] = $fila_equipos['TOTAL_JOR'];
				
			if($fila!=-1){
				$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+1]= $acumulador;
				$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+2]= $acumulador/($contadorNegativo-1);
			}
										
			$acumulador=0;
			$acumulador=$acumulador+$fila_equipos['TOTAL_JOR'];
			$contadorNegativo=2;
			$id_actual=$fila_equipos['ID_EQUI'];
			$contador=2;
			$fila++;							
		}	
			
		if(($fila_equipos['ID_EQUI_CAS']==0)||($fila_equipos['ID_EQUI_VIS']==0)){
			$contadorNegativo=$contadorNegativo-1;
		}
	}//fin while
	$acumulador=$acumulador+$fila_equipos['TOTAL_JOR'];
	$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+1]= $acumulador;
	$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+2]= $acumulador/($contadorNegativo-1);
	
	foreach ($equipos as $key => $fila) {
		$totales[$key]  = $fila[$fila_max_jor['MAX(NUM_JOR)']+2]; // columna de animales
	}
	
	//ordenar los equipos por porcentage
	array_multisort($totales, SORT_ASC, $equipos);
	
	//********************llenar tabla**********************************************************************8
	echo '
	<table cellpadding="0" cellspacing="0" class="tabla">
		<tr  align="center" >
				<td id="titulo" colspan="'.($fila_max_jor['MAX(NUM_JOR)']+5).'">Arco Menos Batido</td>
			</tr>
			<tr id="titulo" >
				<th>Po.</th>
				<th>Equipo</th>';						
				for($i=1;$i<=$fila_max_jor['MAX(NUM_JOR)'];$i++){
					echo '
					<th>'.$i.' F</th>';					
				}
				echo'
				<th> Total </th>
				<th>Prome.</th>
				<th style="border-right:1px solid #ddd;">&ensp;</th>
			</tr>';
	//llenar con equipos					
	for($a=0;$a<count($equipos);$a++){
		echo '
		<tr>
			<td>'.($a+1).'</td>';
		for($i=0;$i<=$fila_max_jor['MAX(NUM_JOR)']+2;$i++){
			if($i!=$fila_max_jor['MAX(NUM_JOR)']+2){
				echo '
				<td>'.$equipos[$a][$i].'&ensp;</td>';
			}
			else{
				echo '
				<td>'.number_format($equipos[$a][$i],2).'&ensp;</td>';
			}
		}
		echo'
			<td style="border-right:1px solid #ddd;">&ensp;</td>
		</tr>';
	}				
	echo'
	</table>';
}
else{
	echo '
	<table cellpadding="0" cellspacing="0" >
		<tr>
			<td>Para mostrar la tabla del arco menos batido, se debe ingresar jornadas</td>
		</tr>
	</table>';
}
?>
 