<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<style type="text/css">
        .contenedor {
			min-height:45px;
			min-width:150px;
			height:auto !important;
			height:45px;
        }
        </style>
        <script src="lib/prototype.js" type="text/javascript"></script>
        <script src="src/scriptaculous.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
	</head>
<body onLoad="crear_drag();">
<?php
include('../conexiones/conec_cookies.php');

//consulta eventos fase de grupos
$sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query_grupo = mysql_query($sql_grupo, $conn);
$cant_grupos=mysql_num_rows($query_grupo);
$row_grupo=mysql_fetch_assoc($query_grupo);

//consulta eventos fase de llave
$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=2";
$query_llave = mysql_query($sql_llave, $conn);
$row_llave=mysql_fetch_assoc($query_llave);
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr bgcolor="#cacaca">
		<td>Avanzar Fase Llaves</td>
        <td align="right">
            <input type="button" onClick="document.location.href='jor_llaves.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>'" value="Cancelar"> 
      	</td>
	</tr>
</table>
<table>
	<tr>
		<td>
			<?php
            $sql_equipos_disponibles="SELECT * FROM t_even_equip
			LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
			WHERE t_even_equip.ID_EVEN=".$row_llave['ID'];
			$query_equipos_disponibles= mysql_query($sql_equipos_disponibles,$conn);
			?>		 
  			<div style="width:200px;background:#CCC;" id="lista" class="lista">
            	<br id="apartir">        
				<?php
				while ($row_equipos_disponibles=mysql_fetch_assoc($query_equipos_disponibles)){
					echo '
					<div class="Equipos" id="e_'.$row_equipos_disponibles["ID"].'" >* '.$row_equipos_disponibles['NOMBRE'].'</div>';
				}?>
			</div>
		</td>
		<td valign="top"><input type="button" value="Resetear" onClick="rellenar();"></td>
	</tr>
</table>

<?php		
if($cant_grupos>0){	
	//consulta para obtener la ultima jornada
	$sql_ultima_jornada_grupos="SELECT  MAX(t_jornadas.NUM_JOR)AS UJORGRU FROM t_jornadas
					WHERE t_jornadas.ID_EVE=".$row_grupo['ID'];
	$consulta_ultima_jornada_grupos = mysql_query($sql_ultima_jornada_grupos, $conn);
	$row_ultima_jornada_grupos=mysql_fetch_assoc($consulta_ultima_jornada_grupos);
	$row_ultima_jornada_grupos['UJORGRU']=$row_ultima_jornada_grupos['UJORGRU']+1;
}
else{
	$row_ultima_jornada_grupos['UJORGRU']=1;
}

//consulta para obtener la ultima jornada llaves
$sql_ultima_jornada_llaves="SELECT  MAX(t_jornadas.NUM_JOR)AS UJORLLAV FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
$consulta_ultima_jornada_llaves = mysql_query($sql_ultima_jornada_llaves, $conn);
$row_ultima_jornada_llaves=mysql_fetch_assoc($consulta_ultima_jornada_llaves);

$jornada=$row_ultima_jornada_grupos['UJORGRU'];
?>
<form action="guardar/guardar_actualizar_llaves.php" method="post" onSubmit="obtenerElementos();">
<input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
<input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
<table >
	<tr>
	<?php
	//ciclo para recorrer las jornadas	
	for($i=$jornada;$i<=$row_ultima_jornada_llaves['UJORLLAV'];$i+=2){
		?>
		<td>
			<table cellpadding="0" cellspacing="0" class="fase">
				<tr  valign="top">
					<th valign="top">Grupo</th>
					<th valign="top">Equipos</th>
					<th valign="top">Jor.<?php echo ($i);?></th>
        <?php
		if(!($i==($row_ultima_jornada_llaves['UJORLLAV']))){
		?>			
					<th valign="top">Jor.<?php echo ($i+1);?></th>
					<th valign="top">Total</th>
		<?php
        }
		?>	
				</tr>
		<?php
		//recorrer todas las jornadas de llaves de dos en dos	
		$sql_total_partidos="SELECT * FROM t_jornadas
				WHERE t_jornadas.ID_EVE=".$row_llave['ID']." AND (t_jornadas.NUM_JOR=".($i)." OR t_jornadas.NUM_JOR=".($i+1).")
				 ORDER BY t_jornadas.GRUPO ASC,t_jornadas.NUM_JOR ASC ";
		$consulta_total_partidos = mysql_query($sql_total_partidos, $conn);
		$cant_partidos = mysql_num_rows($consulta_total_partidos);
			
		$indicador=0;
		$indicador_guardar=0;
		$indicador_final=0;
		//ciclo para recorrer los grupos
		while($fila_equipos=mysql_fetch_assoc($consulta_total_partidos)){		
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
			
			//mostrar marcadores nulos	
			if($fila_equipos['MARCADOR_CASA']==''){
				$marcador_casa='-';
			}
			else{
				$marcador_casa=$fila_equipos['MARCADOR_CASA'];
			}
			//mostrar marcadores nulos	
			if($fila_equipos['MARCADOR_VISITA']==''){
				$marcador_visita='-';
			}
			else{
				$marcador_visita=$fila_equipos['MARCADOR_VISITA'];
			}
			
			//si no es la ultima jornada
			if(!($i==($row_ultima_jornada_llaves['UJORLLAV']))){
				//si es el partido de ida
				if($indicador==0){
					echo'
					<tr>
						<td colspan="5" id="Blanco">&ensp;</td>
					</tr>';
					
					$id_partido_anterior=$fila_equipos['ID'];
					$nombre_equi_casa=$fila_equipo_casa['NOMBRE'];
					$marcador_casa_anterior=$marcador_casa;
					$nombre_equi_vis=$fila_equipo_visita['NOMBRE'];
					$marcador_visita_anterior=$marcador_visita;
					$estado=$fila_equipos['ESTADO'];
					
					$indicador=1;
				}
				//si es el partido de vuelta
				else{
					$indicador=0;
					
					//si es una jornada por jugar y no se an actualizado los equipos
					if(($fila_equipo_casa['NOMBRE']=='LIBRE')&&($fila_equipo_visita['NOMBRE']=='LIBRE')&&(($fila_equipos['ESTADO']==2))||($estado==2)){
						$arreglo_div[]=$fila_equipos['GRUPO'];
						$indicador_guardar=1;
						?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center"  rowspan="2">
									<div style="background:#ccc;width:200px; " class="contenedor grupo_<?php echo $fila_equipos['GRUPO'];?>" 
                                    	id="idPartido_<?php echo $fila_equipos['GRUPO'];?>">
									</div>
                                </td>
								<td align="center" ><?php echo $marcador_casa_anterior;?></td>
								<td align="center" ><?php echo $marcador_visita;?></td>
								<td align="center"><?php echo ($marcador_casa_anterior+$marcador_visita);?></td>
							</tr>
							<tr>
								<td>
                                	&ensp;
									<input type="hidden" name="h_idGrupos[]" value="<?php echo $id_partido_anterior.'/'.$fila_equipos['ID'];?>">
									<input type="hidden" value="" name="h_grupo[]" id="h_idgrupo_<?php echo $fila_equipos['GRUPO'];?>">
								</td>					
								<td align="center" ><?php echo $marcador_visita_anterior;?></td>
								<td align="center" ><?php echo $marcador_casa;?></td>
								<td align="center" ><?php echo ($marcador_visita_anterior+$marcador_casa);?></td>
							</tr>
                    <?php
					}
					//mostrar los partidos sin permitir modificar
					else{
					?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center" ><?php echo $nombre_equi_casa;?></td>
								<td align="center" ><?php echo $marcador_casa_anterior;?></td>
								<td align="center" ><?php echo $marcador_visita;?></td>
								<td align="center" ><?php echo ($marcador_casa_anterior+$marcador_visita);?></td>
							</tr>
							<tr>
								<td>&ensp;</td>
								<td align="center" ><?php echo $nombre_equi_vis;?></td>					
								<td align="center" ><?php echo $marcador_visita_anterior;?></td>
								<td align="center" ><?php echo $marcador_casa;?></td>
								<td align="center" ><?php echo ($marcador_visita_anterior+$marcador_casa);?></td>
							</tr>
                    <?php
					}
				}
			}
			//si es la ultima jornada
			else{
				//si es la primera vuelta
				if($indicador==0){
				echo'
					<tr>
						<td colspan="5" id="Blanco">&ensp;</td>
					</tr>';
					
					//si se tienen que actualizar los equipos
					if(($fila_equipo_casa['NOMBRE']=='LIBRE')&&($fila_equipo_visita['NOMBRE']=='LIBRE')&&($fila_equipos['ESTADO']==2)){
						$arreglo_div[]=$fila_equipos['GRUPO'];
						$indicador_guardar=1;
						
						if($indicador_final==0){
							$indicador_final=1;
						?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center"  rowspan="2">
									<div style="background:#ccc"  class="contenedor grupo_<?php echo $fila_equipos['GRUPO'];?>" 
                                    id="idPartido_<?php echo $fila_equipos['GRUPO'];?>">	
									</div>
								</td>
								<td align="center" ><?php echo $marcador_casa;?></td>
							</tr>
							<tr>
								<td >Final 
									<input type="hidden" name="h_idGrupos[]" value="<?php echo $fila_equipos['ID'];?>">
									<input type="hidden" value="" name="h_grupo[]" id="h_idgrupo_<?php echo $fila_equipos['GRUPO'];?>">
								</td>
								<td align="center" id="final"><?php echo $marcador_visita;?></td>
							</tr>	
						<?php
                        }
						else{
						?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center"  rowspan="2">
									<div style="background:#ccc"  class="contenedor grupo_<?php echo $fila_equipos['GRUPO'];?>" 
                                    id="idPartido_<?php echo $fila_equipos['GRUPO'];?>">	
									</div>
								</td>
								<td align="center" ><?php echo $marcador_casa;?></td>
							</tr>
							<tr>
								<td>3Lugar
									<input type="hidden" name="h_idGrupos[]" value="<?php echo $fila_equipos['ID'];?>">
									<input type="hidden" value="" name="h_grupo[]" id="h_idgrupo_<?php echo $fila_equipos['GRUPO'];?>">
								</td>
								<td align="center" id="final"><?php echo $marcador_visita;?></td>
							</tr>
                        <?php
						}
					}
					//si no permite modificar
					else{
						if($indicador_final==0){
							$indicador_final=1;
							?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center" ><?php echo $fila_equipo_casa['NOMBRE'];?></td>
								<td align="center" ><?php echo $marcador_casa;?></td>
							</tr>
							<tr>
								<td>Final</td>
								<td align="center" ><?php echo $fila_equipo_visita['NOMBRE'];?></td>					
								<td align="center" ><?php echo $marcador_visita;?></td>
							</tr>
                        <?php
						}
						else{
						?>
							<tr>
								<td align="center" ><?php echo $fila_equipos['GRUPO'];?></td>
								<td align="center" ><?php echo $fila_equipo_casa['NOMBRE'];?></td>
								<td align="center" ><?php echo $marcador_casa;?></td>
							</tr>
							<tr>
								<td>3Lugar</td>
								<td align="center" ><?php echo $fila_equipo_visita['NOMBRE'];?></td>					
								<td align="center" ><?php echo $marcador_visita;?></td>
							</tr>
						<?php
                        }
					}
				}
			}// if para determinar si es la ultima jornada
		}//fin ciclo while
		
		if($indicador_guardar==1){
		?>	
			<tr>
				<td colspan="3" align="right">
                	<input type="submit" value="Guardar"> 
              	</td>
			</tr>
        <?php
		}
		?>
		
		</table>
		</td>
    <?php
	}
	?>
	</tr>
</table>
</form>
<script type="text/javascript">
var arra_items=new Array();
var arra_nom=new Array();
<?php
$i=0;
$query= mysql_query($sql_equipos_disponibles,$conn);
while ($row=mysql_fetch_assoc($query)){
	echo 'arra_items['.$i.']='.$row['ID'].';
	arra_nom['.$i.']="* '.$row['NOMBRE'].'";';
	$i++;
}
?>

function rellenar(){
var i;
var lista=(document.getElementById('lista'));
	for(i=0;i<arra_items.length;i++){	
		var cadena='e_'+arra_items[i];
		var contenedores=document.getElementById(cadena);
		contenedores.parentNode.removeChild(contenedores);
	
		var texto = document.createTextNode(arra_nom[i]);
		var elemento = document.createElement("div");
		elemento.id = "e_"+arra_items[i];
		var atributo = document.createAttribute("class");
		atributo.nodeValue ="Equipos";
		elemento.attributes.setNamedItem(atributo);
		elemento.appendChild(texto);
		lista.appendChild(elemento);		
	}
crear_drag();
}

function crear_drag(){
	var este =new Array();
	var i;
	este[0]="lista";
	
	<?php
	for($i=0;$i<count($arreglo_div);$i++){
		echo 'este['.($i+1).']="idPartido_'.$arreglo_div[$i].'";';
	}
	?>

	cantidad_grupos=<?php echo count($arreglo_div); ?>;

	for(i=0;i<=cantidad_grupos;i++){
		
		Sortable.create(este[i],{
		tag:'div',
		dropOnEmpty: true, 
		containment:este,
		constraint:false});
	}
}
function obtenerElementos() {
	var arreglo_div =new Array();
	var arreglo_hidden=new Array();
	<?php
	for($i=0;$i<count($arreglo_div);$i++){
		echo '
			arreglo_div['.($i).']="idPartido_'.$arreglo_div[$i].'";
			arreglo_hidden['.($i).']="h_idgrupo_'.$arreglo_div[$i].'";';
	}
	?>
	cantidad_grupos=<?php echo count($arreglo_div); ?>;	
	for(i=0;i<cantidad_grupos;i++){
		
		var cadena=Sortable.serialize(arreglo_div[i]);
		var hidden=document.getElementById(arreglo_hidden[i]);
		cadena=cadena.split('&');
		cadena=cadena.join();
		cadena=cadena.split(arreglo_div[i]+"[]=");
		cadena=cadena.join();
		cadena=cadena.split(',,');
		cadena=cadena.join();
		hidden.value=cadena.slice(1,cadena.length);
	}
	document.formulario.CAN_PAR.value=cantidad_partidos;
	document.formulario.cant_fases.value=total_fases;
			
	return false;
}

</script>
</body>
</html>