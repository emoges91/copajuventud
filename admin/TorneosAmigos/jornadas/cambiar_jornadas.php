<script src="../js/funciones.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');

//-----------------------------------grupos----------------------------------------
$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query = mysql_query($sql, $conn);
$row=mysql_fetch_assoc($query);
	
$cadena_equi="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row['ID'].' AND GRUPO='.$_GET['NUM_GRU'].
				' ORDER BY t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ';
$consulta_jornadas = mysql_query($cadena_equi, $conn);

$i=0;
$cant_jor=1;
$arrayJornadas='';
while($fila_jornada=mysql_fetch_assoc($consulta_jornadas)){
	$arrayJornadas[$i][0]=	$fila_jornada['ID'];
	$arrayJornadas[$i][1]=	$fila_jornada['ID_EQUI_CAS'];
	$arrayJornadas[$i][2]=	$fila_jornada['ID_EQUI_VIS'];
	$arrayJornadas[$i][3]=	$fila_jornada['FECHA'];
	$arrayJornadas[$i][4]=	$fila_jornada['ESTADO'];
	$arrayJornadas[$i][5]=	$fila_jornada['NUM_JOR'];
	$arrayJornadas[$i][6]=	$fila_jornada['ID_EVE'];
	$arrayJornadas[$i][7]=	$fila_jornada['GRUPO'];
	$arrayJornadas[$i][8]=	$fila_jornada['MARCADOR_CASA'];
	$arrayJornadas[$i][9]=	$fila_jornada['MARCADOR_VISITA'];
	$arrayJornadas[$i][10]=	$fila_jornada['CANCHA'];
	$arrayJornadas[$i][11]=	$fila_jornada['HORA'];
	if($arrayJornadas[($i-1)][5]<>$arrayJornadas[$i][5]){
		$cant_jor++;
	}
	$i++;
}
?>
<form name="formulario" action="guardar/guardar_orden_jornadas.php" enctype="multipart/form-data" method="post" onSubmit="return ordenJornadas();" id="formulario">
<input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
<input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
<table width="100%">
	<tr bgcolor="cacaca">
	   	<td>Cambiar orden de jornadas de <?php echo $row['NOMBRE'];?></td>	
        <td align="right"  width="330px">
        	<input type="submit" value="Guardar"/>
           	<input type="button" onclick="document.location.href='jor_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Cancelar">                
        </td>
	</tr>
	<tr>
		<td>
            <table cellpadding="0" cellspacing="0" class="jornadas">
			<?php
			for($e=0;$e<=($i-1);$e++){		
				
				//--------------------mostrar el nombre de la jornada----------
				if($arrayJornadas[$e][5]<>$comparar_jornadas){	
			?>		
            		<tr>
						<td colspan="10"  id="Blanco"  align="center">&ensp;</td>
					</tr>
					<tr>
                    	<td colspan="10" id="Njornadas2" align="center" style="border-right:1px solid #ddd;">                        	
							<select name="CbBPosicion<?php echo $arrayJornadas[$e][5];?>" id="IdCbBPosicion<?php echo $arrayJornadas[$e][5];?>"
                            style="float:left;" title="Orden jornada" 
                            onchange="cambiarCombo('IdCbBPosicion<?php echo $arrayJornadas[$e][5];?>',<?php echo $arrayJornadas[$e][5];?>);"> 
                            	<?php
                                For($a=1;$a<=($cant_jor-1);$a++){
                                	if($a==$arrayJornadas[$e][5]){
										$checked='selected="selected"';
									}
									else{
										$checked='';
									}
									echo '<option value="'.$a.'" '.$checked.' >'.$a.'</option>';
                                } 
								?>
                            </select>
							Jornada <?php echo $arrayJornadas[$e][5];?>
                      	</td> 
					</tr>
					<tr>
                        <th>Equipo Casa</th>
                        <th>Marcador</th>
                        <th></th>
                        <th>Equipo visita</th>
                        <th>Marcador</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th style="border-right:1px solid #ddd;">Grupo</th>
					</tr>
				<?php
				}// fin de mostrar encabezado jornada
				
				//-------------------mostrar cuando el equipo casa esta libre---------
				if($arrayJornadas[$e][1]<>0){
					$str_query_equi_casa="SELECT * FROM t_equipo
						WHERE t_equipo.ID=".$arrayJornadas[$e][1];
					$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
					$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
				}
				else{
					$fila_equipo_casa['NOMBRE']='LIBRE';
				}
				
				//-------------------mostrar cuando el equipo visita esta libre---------
				if($arrayJornadas[$e][2]<>0){
					$str_query_equi_visita="SELECT * FROM t_equipo
						WHERE t_equipo.ID=".$arrayJornadas[$e][2];
					$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
					$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
				}
				else{
					$fila_equipo_visita['NOMBRE']='LIBRE';
				}
				
				//---------------------si el marcador casa es null----------------------
				if($arrayJornadas[$e][8]==''){
					$marcador_casa='-';
				}
				else{
					$marcador_casa=$arrayJornadas[$e][8];
				}
				
				//---------------------si el marcador visita es null----------------------
				if($arrayJornadas[$e][9]==''){
					$marcador_visita='-';
				}
				else{
					$marcador_visita=$arrayJornadas[$e][9];
				}
				
				$estado_partido='';
				switch($arrayJornadas[$e][4]){
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
				<tr>
					<td align="center" ><?php echo $fila_equipo_casa['NOMBRE'];?></td>
					<td align="center" ><?php echo $marcador_casa;?></td>
					<td align="center" >Vrs</td>
					<td align="center" ><?php echo $fila_equipo_visita['NOMBRE'];?></td>
					<td align="center" ><?php echo $marcador_visita;?></td>
					<td align="center" ><?php echo cambiaf_a_normal($arrayJornadas[$e][3]);?></td>
					<td align="center" ><?php echo $estado_partido;?></td>
					<td align="center" style="border-right:1px solid #ddd;" ><?php echo $arrayJornadas[$e][7];?></td>
				</tr>    
			<?php
			
				$comparar_jornadas=$arrayJornadas[$e][5];
				
				$idsJornas=$arrayJornadas[$e][0].','.$idsJornas;
				if($arrayJornadas[$e+1][5]<>$comparar_jornadas){	
					 echo '<input type="hidden" name="HidIdJornadas'.$arrayJornadas[$e][5].'" value="'.$idsJornas.'">'; 
					 $idsJornas='';
				}
			}
			?>
            <input type="hidden" name="total_jornadas" value="<?php echo $comparar_jornadas;?>">
			</table>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript" >
	var total_jornadas=<?php echo $comparar_jornadas;?>;
	var array_jornadas=new Array();
	<?php 
	for($j=1;$j<=$comparar_jornadas;$j++){	
		echo "array_jornadas[".$j."]=".$j.";";
	}
	?>
	
	function cambiarCombo(combo,num){
		var CbBOrden=document.getElementById(combo);
		var nuevoValor = CbBOrden.options[CbBOrden.selectedIndex].value;
		var valorAnterior=array_jornadas[num]
		
		for(var i=1;i<=total_jornadas;i++){
			if(nuevoValor==array_jornadas[i]){	
				var CbBcomboBusqueda=document.getElementById('IdCbBPosicion'+i);
				CbBcomboBusqueda.selectedIndex=(valorAnterior-1);
				array_jornadas[i]=valorAnterior;
			}
		}
		array_jornadas[num]=nuevoValor;
	}
</script>