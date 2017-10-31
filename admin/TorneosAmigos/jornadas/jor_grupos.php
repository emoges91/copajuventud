<script src="../js/funciones.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include_once('../conexiones/conec_cookies.php');
include_once('../FPHP/funciones.php');

$dire='../';
include_once('../mostrar_torneo.php');
//-----------------------------------grupos----------------------------------------
$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
$row=mysql_fetch_assoc($query);

$cadena_siguiente="SELECT NUM_JOR FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row['ID'].' AND ESTADO=2 AND NUM_JOR=1'.
				' ORDER BY t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ';
$consulta_siguientes = mysql_query($cadena_siguiente, $conn);
$cant_sgt = mysql_num_rows($consulta_siguientes);		
	
if ($cant>0){
	
	$cadena_equi="SELECT * FROM t_jornadas
					WHERE t_jornadas.ID_EVE=".$row['ID'].
					' ORDER BY t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ';
	$consulta_total_grupos = mysql_query($cadena_equi, $conn);
	$cant_jor = mysql_num_rows($consulta_total_grupos);
	
	if($cant_jor>0){
?>
   	    <table width="100%">
            <tr bgcolor="#cacaca">
            	<td><?php echo $row['NOMBRE'];?></td>	
                <td align="right"  width="330px">
                	<input type="button" onclick="document.location.href='ingr_marca_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Ingresar Marcadores">
             		<input type="button" onclick="document.location.href='partidos_pendientes_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Partidos Pendientes">                
                </td>
            </tr>
            <?php if($cant_sgt>0){?>
            <tr>
            	<td colspan="2" align="left" style="padding-top:20px;">
                	<?php
						$str_max_grupo="SELECT MAX(GRUPO) as MAXGRUPO FROM t_jornadas
										WHERE t_jornadas.ID_EVE=".$row['ID'];
						$consulta_max_grupo = mysql_query($str_max_grupo, $conn);
						$row_max_grupo=mysql_fetch_assoc($consulta_max_grupo);
					?>
                    Cambiar ornden de jornada en grupo:
                    <div class="divCambOrd">
                    <table  cellpadding="0" cellspacing="0" >
                    	<tr>
                        	<?php for($o=1;$o<=$row_max_grupo['MAXGRUPO'];$o++){?>
                        	<td align="left">
                			<input name="CambiarOrdenJornadas" type="button" value="Grupo <?php echo $o;?>"
                    		onclick="document.location.href='cambiar_jornadas.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>&NUM_GRU=<?php echo $o;?>';"/>
                    		</td>
                            <?php
                            }
							?>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
            <?php }?>
            <tr>
			<td>
            	<table cellpadding="0" cellspacing="0" class="jornadas">
			<?php
			while($total_grupos=mysql_fetch_assoc($consulta_total_grupos)){
				$etiqueta='Jornada '.$total_grupos['NUM_JOR'];			
				
				//--------------------mostrar el nombre de la jornada----------
				if($total_grupos['NUM_JOR']<>$comparar_jornadas){	
			?>		
            		<tr>
						<td colspan="10"  id="Blanco"  align="center">&ensp;</td>
					</tr>
					<tr>
						<td colspan="9" id="Njornadas" align="center" style="border-right:1px solid #ddd;">
							<?php echo $etiqueta;?>
                      	</td>
                        <td id="tdcancha" align="center">
                        	<a href="ingr_cancha_fecha.php?NUM_JOR=<?php echo $total_grupos['NUM_JOR'];?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>&TIPO=1">
								<img src="../img/ico_cancha_hora.png" title="Asugnar a esta jornada cancha/fecha/hora"/>
							</a>
                        </td>
					</tr>
					<tr bgcolor="#FFFF99">
                        <th></th>
                        <th></th>
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
				}
				
				//-------------------mostrar cuando el equipo casa esta libre---------
				if($total_grupos['ID_EQUI_CAS']<>0){
					$str_query_equi_casa="SELECT * FROM t_equipo
						WHERE t_equipo.ID=".$total_grupos['ID_EQUI_CAS'];
					$consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
					$fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
				}
				else{
					$fila_equipo_casa['NOMBRE']='LIBRE';
				}
				
				//-------------------mostrar cuando el equipo visita esta libre---------
				if($total_grupos['ID_EQUI_VIS']<>0){
					$str_query_equi_visita="SELECT * FROM t_equipo
						WHERE t_equipo.ID=".$total_grupos['ID_EQUI_VIS'];
					$consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
					$fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
				}
				else{
					$fila_equipo_visita['NOMBRE']='LIBRE';
				}
				
				//---------------------si el marcador casa es null----------------------
				if($total_grupos['MARCADOR_CASA']==''){
					$marcador_casa='-';
				}
				else{
					$marcador_casa=$total_grupos['MARCADOR_CASA'];
				}
				
				//---------------------si el marcador visita es null----------------------
				if($total_grupos['MARCADOR_VISITA']==''){
					$marcador_visita='-';
				}
				else{
					$marcador_visita=$total_grupos['MARCADOR_VISITA'];
				}
				
				$estado_partido='';
				switch($total_grupos['ESTADO']){
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
					<td align="center" bgcolor="#EFF1FC">
						<a href="editar_jornada.php?ID_JOR=<?php echo $total_grupos['ID'];?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">
							<img src="../img/icono_editar.png" title="Editar"/>
						</a>
					</td>
					<td align="center" bgcolor="#DADEFC">
						<a href="editar/voltear.php?ID_JOR=<?php echo $total_grupos['ID'];?>&ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>" onclick="javascript: return voltear();">
							<img src="../img/cambiar.png" title="Voltear" width="25px"/>
						</a>
					</td>
					<td align="center" ><?php echo $fila_equipo_casa['NOMBRE'];?></td>
					<td align="center" ><?php echo $marcador_casa;?></td>
					<td align="center" >Vrs</td>
					<td align="center" ><?php echo $fila_equipo_visita['NOMBRE'];?></td>
					<td align="center" ><?php echo $marcador_visita;?></td>
					<td align="center" ><?php echo cambiaf_a_normal($total_grupos['FECHA']);?></td>
					<td align="center" ><?php echo $estado_partido;?></td>
					<td align="center" style="border-right:1px solid #ddd;" ><?php echo $total_grupos['GRUPO'];?></td>
				</tr>
			<?php  
				$comparar_jornadas=$total_grupos['NUM_JOR'];
			}
			?>
				</table>
			</td>
		<?php
        }
		else{
		 	echo "<script type=\"text/javascript\">
				alert('Las jornadas de fase de grupos no se encuentran creadas ');
				document.location.href='crear_jornadas_grupos.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';
			</script>";
		}
		?>
			</tr>
			</table>
    <?php
	}
	else{
		echo 'No se encuentran jornadas para los grupos.';
	}
?>