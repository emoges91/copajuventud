<?php
include('../conexiones/conec_cookies.php');
?>
<html>
<head>
	<script src="js/crearJornadasGrupos.js" type="text/javascript" charset="utf-8"></script>	
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
</head>
<body>

<?php
	//-------------------------------consultar el evento grupo----------------------------------------
	$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
	$query = mysql_query($sql, $conn);
	$cant = mysql_num_rows($query);
	$row=mysql_fetch_assoc($query);

	//selescionar los equipos
	$cadena_equi="SELECT MAX(t_even_equip.NUM_GRUP)as MAXGRUPO FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				WHERE t_even_equip.ID_EVEN=".$row['ID'];
	$consulta_total_grupos = mysql_query($cadena_equi, $conn);
	$total_grupos=mysql_fetch_assoc($consulta_total_grupos);

	if ($cant>0){
	?>
		<form action="guardar/guardar_jornadas_grupos.php" enctype="multipart/form-data" method="post"/>
            <input type="hidden" value="<?php echo $_GET['ID']; ?>" name="id_torneo"/>
            <input type="hidden" value="<?php echo $_GET['NOMB']; ?>" name="id_nombtorneo"/>
			<input type="hidden" value="<?php echo $row['ID']; ?>" name="id_evento"/>
			<table width="100%" >
				<tr bgcolor="#CCCCCC">
					<td colspan="<?php echo $total_grupos['MAXGRUPO'];?>" align="right"><input type="submit"  value="Guardar"></td>
				</tr>
				<tr>
        <?php
		//si el ultimo grupo es mayor a 0
		if($total_grupos['MAXGRUPO']>0){
			$cont=1;
			//recorrer los grupos desde el primero hasta el ultimo
			for($i=1;$i<=$total_grupos['MAXGRUPO'];$i++){	
				
				$cadena_equi="SELECT * FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				WHERE t_even_equip.ID_EVEN=".$row['ID']." and t_even_equip.NUM_GRUP=".$i.
				" ORDER BY t_even_equip.ID";
				$consulta_equipos = mysql_query($cadena_equi, $conn);
				
				// si son mas de 4
				if($cont==4){
				?>
					</tr>
					<tr>
            	<?php
					$cont=1;
				}
				?>
					<td valign="top">				
					<table class="grupos">
                        <tr bgcolor="#F9BB60">
                            <td colspan="4">Grupo<?php echo $i; ?></td>
                        </tr>
				
                		<?php
						//recorrer los equipos del grupo
						while($fila_equi=mysql_fetch_assoc($consulta_equipos)){
							$array_equipo[]=$fila_equi['NOMBRE'];// array de los nombres de los equipos
							$array_idequipo[]=$fila_equi['ID'];// array con los id de los equipos
							$con++;	
						}
						
						//aqui comienza el ordenamiento de los partidos y jornadas
						$cexg=count($array_equipo);//cantidad de equipos
						
						// si la cantidad de equipo el resifio de la divicion no es cero
						if(($cexg%2)!=0){
							$cexg=$cexg+1;//agregue un equipo fantasma
							$array_equipo[$cexg-1]=" LIBRE ";//agreguar un nombre equipo libre
							$array_idequipo[$cexg-1]=" ";// agregar un id vacio 
						}	
					
						$nj=($cexg-1)*2;// calcular el numero de jornadas
						$mj=$nj/2;//mitad de jornadas
						$mitad=$cexg/2;//mitad de equipos
						$x2=$mitad;//asignar la mitad de los equipos
						
						//recorrer las jornadas
						for($u=1;$u<=$nj;$u++){
							//-----recorrer todos los equipos y poner el arreglo revisar en blanco en blanco----
							for($o=0;$o<=$cexg;$o++){
								$revisar_equipos[$o]=0;//arreglo para revisar equipos
							}
							
							$revisar_equipos[$cexg+1]=1;// a la cantidad de equipos + 1 asignele 1
							$revisar_equipos[0]=1;// al primero asignele 1
						?>
							<!------------------encabezado de jornada-->
							<tr bgcolor="#ededed">
								<td colspan="4">Jornada <?php echo $u; ?></td>
							</tr>
                        	<?php
   							$x1=1;// x1= primer equipo de la matriz
							// si la mitad de equipos es menor a cantidad de equipos
   							if($x2<$cexg){
   								$x2+=1;// a la mitad de quipos sumele uno
   							}
   							else{
     							$x2=$x1+1;//a la mitad de equipos pongale el valor de x +1
   							}
   							$y2=$x2;// obtiene la posicion de la array del contrincante
   						
							//recorrer la mitad de equipos
							for($e=1;$e<=$mitad;$e++){
								$nombre_input='g_'.$i.'[]';//nombre del hidden de los id de los equipos
								$nombre_input2='h_'.$i.'[]';//nombre del hidden de los id de los equipos
								
								// si la jornada actual es mayor a mitad de jornadas ejecute la vuelta
								if($u>$mj){
									$ids2='v_'.$i.'_'.$y2.'_'.$u;//id del td del equipos casa
									$ids1='v_'.$i.'_'.$x1.'_'.$u;//id del td del equipo visita
																	
									echo '
									<tr>
										<td>
											<input type="button" value="voltear" onClick="invertir('.$y2.','.$x1.','.$i.','.$mj.','.$u.');">
										</td>
										<td id="'.$ids2.'">
											'.$array_equipo[$y2-1].'
											<input id="'.$ids2.'_hdn" type="hidden" value="'.$array_idequipo[$y2-1].'" name="'.$nombre_input.'">
											<input id="'.$ids1.'_hdn" type="hidden" value="'.$array_idequipo[$x1-1].'" name="'.$nombre_input2.'">
										</td>									
										<td width="40px">
											&ensp;vrs&ensp;
										</td>
										<td id="'.$ids1.'">
											'.$array_equipo[$x1-1].'
										</td>
									</tr>';
     	 							$matriz_equipos[$y2][$x1]=1;//colocar en la matriz como enfrentados los dos equipos
         						}
         						else{// confeccionar partidos ida
									$ids2='i_'.$i.'_'.$y2.'_'.$u;
									$ids1='i_'.$i.'_'.$x1.'_'.$u;
								
								echo '
									<tr>
										<td>
											<input type="button" value="voltear" onClick="invertir('.$x1.','.$y2.','.$i.','.$mj.','.$u.');">
										</td>
										<td id="'.$ids1.'">
											'.$array_equipo[$x1-1].'
											<input id="'.$ids1.'_hdn" type="hidden" value="'.$array_idequipo[$x1-1].'" name="'.$nombre_input.'">
											<input id="'.$ids2.'_hdn" type="hidden" value="'.$array_idequipo[$y2-1].'" name="'.$nombre_input2.'">
										</td>
										<td width="40px">
											&ensp;vrs&ensp;
										</td>
										<td id="'.$ids2.'">
											'.$array_equipo[$y2-1].'
										</td>							
									</tr>';
     	 						$matriz_equipos[$x1][$y2]=1;//colocar en la matriz como enfrentados los dos equipos
         					}

							$revisar_equipos[$x1]=1;//matriz para revisar q los equipos han sido utilizados esta jornada
   							$revisar_equipos[$y2]=1;//matriz para revisar q los equipos han sido utilizados esta jornada
      						
							//recorrer el proximo equipo sin usar
							while($revisar_equipos[$x1]==1){
      							$x1++;
      						}
							
							//recorrer el proximo equipo contrincante sin usar
      						while(($x1==$y2)||($revisar_equipos[$y2]==1)
							||(($matriz_equipos[$x1][$y2]==1)&&($matriz_equipos[$y2][$x1]==1))
							||(($matriz_equipos[$x1][$y2]==1)&&($u<=$mj)) ){
         						if(($y2<$cexg)){
      								$y2++;
         						}
         						else{
         							$y2=$x1+1;
         						}
      						}
						}
					}
				//hasta aqui
				
			unset($array_equipo);//resetear arreglo con los nombre de los equipos
			unset($matriz_equipos);//resetear matriz para comparar si los equipos ya se han efrentado
			unset($revisar_equipos);//resetear la arreglo q comprueba el agregado de los equipos a la jornada
			unset($array_idequipo);//resetear arreglo con los id de los equipos
			
			echo'
			<input type="hidden" name="jornadas_grupo[]" value="'.$nj.'">
			</table></td>';
			
			}
			
		}
	echo '</tr>
		<input type="hidden" name="num_grupos" value="'.($i-1).'">
		</form>
		</table>';
	}
	else{
		echo 'no se pudo registrar los grupos';
	}
?>
</body>
</html>

