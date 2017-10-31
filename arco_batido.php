<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/tabla_estilo.css" type="text/css" />
<?php
include('admin/conexiones/conec.php');

$cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
$consulta_torneo= mysql_query($cadena, $conn);
$cant_tor= mysql_num_rows($consulta_torneo);
?>
<!-- Save for Web Slices (otro2.psd) -->
<table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_01.png) no-repeat; width:1062px; height:14px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/otras_img/otro_02.png) repeat-y; width:14px; height:284px;">
			</td>
		<td style="background:url(img/otras_img/otro_03.png) repeat-y; width:1035px; height:284px;" valign="top">
        	<!--qui empieza el codigo-->
            <link rel="stylesheet" href="css/tabla_estilo.css" type="text/css" />
			<?php
            if($cant_tor>0){
				//EJECUTAR CONSULTA
				$fila_torneo=mysql_fetch_assoc($consulta_torneo);
				
				echo '
				<table align="center">
					<tr align="center">
						<td><font face="Comic Sans MS, cursive" size="+2" color="#0066CC">'.$fila_torneo['NOMBRE'].' '.$fila_torneo['YEAR'].'</font></td>
					</tr>
					<tr>
                		<td>&nbsp;</td>
                	</tr>
				</table>
				';
				
				//consulta grupos
				$str_grupos="SELECT ID FROM t_eventos 
					WHERE TIPO=1 AND ID_TORNEO=".$fila_torneo['ID'];
				$query_grupos=mysql_query($str_grupos, $conn);
				$fila_grupos= mysql_fetch_assoc($query_grupos);
				
				//consulta llaves
				$str_llaves="SELECT ID FROM t_eventos 
					WHERE TIPO=2 AND ID_TORNEO=".$fila_torneo['ID'];
				$query_llaves=mysql_query($str_llaves, $conn);
				$fila_llaves= mysql_fetch_assoc($query_llaves);
				
				$condicion_query=" WHERE ((ID_EVE=".$fila_grupos['ID'].") OR (ID_EVE=".$fila_llaves['ID'].")) 
				and ((t_jornadas.ESTADO=4) OR (t_jornadas.ESTADO=3))";
				
				//consultar el maximo de jornadas
				$cadena_max_jor = "SELECT MAX(NUM_JOR) FROM t_jornadas ".$condicion_query;
				$consulta_max_jor= mysql_query($cadena_max_jor, $conn);
				$cant_max_jor= mysql_num_rows($consulta_max_jor);
				
				if($cant_max_jor>0){
					$fila_max_jor=mysql_fetch_assoc($consulta_max_jor);
					
					//consultar el maximo de jornadas
					$cadena_equipos = "SELECT *,	
						IF (t_jornadas.ID_EQUI_CAS<>t_equipo.ID,
							IFNULL(t_jornadas.MARCADOR_CASA,0),
							IFNULL(t_jornadas.MARCADOR_VISITA,0)
						)
						AS TOTAL_JOR,t_equipo.ID AS ID_EQUI  
						 FROM  t_equipo
						LEFT JOIN t_jornadas ON (t_equipo.ID=t_jornadas.ID_EQUI_CAS) OR (t_equipo.ID=t_jornadas.ID_EQUI_VIS)
						".$condicion_query."
						ORDER BY t_equipo.ID ASC,t_jornadas.NUM_JOR ASC";
					$consulta_equipos= mysql_query($cadena_equipos, $conn);
					
					
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
								//echo $equipos[$fila][0]." ".$acumulador."/(".$contadorNegativo."-1)<br>";
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
							//echo $fila_equipos['NOMBRE']."<br>";
						}
						/*echo $contador." ".$fila_equipos['ID_EQUI']." ".$id_actual;*/
					}
					$acumulador=$acumulador+$fila_equipos['TOTAL_JOR'];
					$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+1]= $acumulador;
					$equipos[$fila][$fila_max_jor['MAX(NUM_JOR)']+2]= $acumulador/($contadorNegativo-1);
					
					foreach ($equipos as $key => $fila) {
            			$totales[$key]  = $fila[$fila_max_jor['MAX(NUM_JOR)']+2]; // columna de animales
        			}
					
					array_multisort($totales, SORT_ASC, $equipos);

					//$equipos=orderMultiDimensionalArray($equipos,'TOTAL_JOR',false);
					
					echo '
					<table align="center" cellpadding="0" cellspacing="0">
						<tr class="caption" align="center">
							<td colspan="'.($fila_max_jor['MAX(NUM_JOR)']+3).'">Arco Menos Batido</td>
						</tr>
						<tr id="titulo" style="color:#fff;">
							<td>Nombre del equipo</td>';						
					for($i=1;$i<=$fila_max_jor['MAX(NUM_JOR)'];$i++){
							echo '
							<td>'.$i.' F</td>';
							
					}
					echo'
							<td> Total </td>
							<td>Prome.</td>
						</tr>';
					
					$indi=0;	
					$clase="";
					for($a=0;$a<count($equipos);$a++){
						if($indi==0){
							$clase=' class="normal"';
							$indi=1;
						}
						else{
							$clase=' class="odd"';
							$indi=0;
						}
						
						echo '
						<tr '.$clase.' id="cuerpo">';
						for($i=0;$i<=$fila_max_jor['MAX(NUM_JOR)']+2;$i++){
							if($i!=$fila_max_jor['MAX(NUM_JOR)']+2){
								echo '
									<td>'.$equipos[$a][$i].'</td>
								';
							}
							else{
								echo '
									<td>'.number_format($equipos[$a][$i],2).'</td>
								';
							}
						}
						echo'
						</tr>';
					}
					
					
					echo'
					</table>';
					
				}
				else{
					echo '
					<center>Las jornadas no han sidos creadas</center>
					';
				}
				
            }
			else{
				echo '
				<center>El torneo no ha sido posteado</center>
				';
			}
			?>
            <!--aqui termina-->
			</td>
		<td style="background:url(img/otras_img/otro_04.png) repeat-y; width:13px; height:284px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_05.png) no-repeat; width:1062px; height:71px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td style="background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;">
        <?php include('content_oficial_horizontal.html');?>
			</td>
		<td style="background:url(img/img_ini/inicio_22.png) repeat-y; width:13px; height:66px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ini/inicio_23.png) no-repeat; width:1062px; height:18px;">
			</td>
	</tr>
</table>