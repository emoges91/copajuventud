<link rel="stylesheet" href="css/utiles.css" type="text/css" />
<script>
function medidascaja(id){
    //calculo la altura actual de la caja
    var elemento = document.getElementById(id).offsetHeight;
	var elemento2 = document.getElementById(id).offsetWidth;
    //si es mayor a 50, le aplico css para dejar su altura en 50
    if(elemento > 100){
        document.getElementById(id).style.height = '100px';
    }
	if(elemento2 > 200){
        document.getElementById(id).style.width = '200px';
    }
}
window.onload = function(){
    medidascaja('imagen');
}

</script>
<table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_01.png) no-repeat; width:1062px; height:14px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/otras_img/otro_02.png) repeat-y; width:14px; height:284px;">
			</td>
		<td style="background:url(img/otras_img/otro_03.png) repeat-y; width:1035px; height:284px;" valign="top">
			<?php
			include('admin/conexiones/conec.php');

			$sql = "SELECT * FROM t_equipo WHERE ID = '".$_GET['id']."'";
			$query = mysql_query($sql, $conn)or die(mysql_error());

			$sql_est = "SELECT *,(t_est_equi.GOL_ANO-t_est_equi.GOL_RES)as GD,(t_est_equi.GOL_ANO_ACU-t_est_equi.GOL_RES_ACU)as GD_ACU FROM t_est_equi 
						LEFT JOIN t_torneo ON t_est_equi.ID_TORNEO = t_torneo.ID
					WHERE t_est_equi.ID_EQUI = ".$_GET['id']."
					ORDER BY t_est_equi.ID ASC";
			$query_est = mysql_query($sql_est, $conn)or die(mysql_error());

			if($fila=mysql_fetch_assoc($query)){
			?>
				<table width="100%" border="0">
					<tr>
						<td>
							<a class="hiper" href="index.php?pag=ver_equipo.php&id_equi=<?php echo $_GET['id']; ?>">Perfil Equipo</a>
        				</td>
    				</tr>
				</table>
				<table width="100%" align="center">
					<tr>
    					<td align="center" colspan="2"><img id="imagen" src="admin/<?php echo $fila['url']; ?>" width="150px"></td>
    				</tr>
    				<tr>
    					<td align="center" colspan="2">
							<font face="Comic Sans MS, cursive" size="+1" color="#0066CC"><?php echo $fila['NOMBRE']; ?></font>
                      	</td>
   					</tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
    			<?php
    			while($fila_est=mysql_fetch_assoc($query_est)){
					$totaltar=0;
					$sqltarjug = "SELECT * FROM t_est_jug_disc WHERE ID_TORNEO=".$fila_est['ID']." AND ID_EQUIPO=".$_GET['id']."";
					$queryjug = mysql_query($sqltarjug, $conn);
					$taramajug = 0;
					$tarrojjug = 0;
					while ($canttar=mysql_fetch_assoc($queryjug))
					{
						$taramajug = $taramajug + $canttar['TAR_AMA'];	
						$tarrojjug = $tarrojjug + $canttar['TAR_ROJ'];
					}
					$sqltarequi = "SELECT * FROM t_est_equi_disc WHERE ID_TORNEO=".$fila_est['ID']." AND ID_EQUIPO=".$_GET['id']."";
					$queryequi = mysql_query($sqltarequi, $conn);
					$taramaequi = 0;
					while ($canttarequi=mysql_fetch_assoc($queryequi))
					{
						$taramaequi = $taramaequi + $canttarequi['TAR_AMA']; 	
					}
					$totaltar=$taramajug+$taramaequi+($tarrojjug*3);
					echo '
					<tr>
						<td colspan="2" align="center">
							<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif">'.$fila_est['NOMBRE'].' '.$fila_est['YEAR'].'</font>
						</td>
					</tr>
					<tr valign="top">
						<td align="center">
							<table class="tabla_prin" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td rowspan="2" valign="top" class="odd"><b>&ensp;Fase de grupos&ensp;</b></td>
									<td class="titulo">PJ</td>
									<td class="titulo">PG</td>
									<td class="titulo">PE</td>
									<td class="titulo">PP</td>
									<td class="titulo">GA</td>
									<td class="titulo">GR</td>
									<td class="titulo">GD</td>
									<td class="titulo">PTS</td>
								</tr>
								<tr class="normal">
									<td>'.$fila_est['PAR_JUG'].'</td>
									<td>'.$fila_est['PAR_GAN'].' </td>
									<td>'.$fila_est['PAR_EMP'].' </td>
									<td>'.$fila_est['PAR_PER'].' </td>
									<td>'.$fila_est['GOL_ANO'].' </td>
									<td>'.$fila_est['GOL_RES'].' </td>
									<td>'.$fila_est['GD'].' </td>
									<td>'.$fila_est['PTS'].' </td>
								</tr>
							</table>
						</td>
						<td align="center">
							<table align="center" class="tabla_prin">
								<tr>
									<td rowspan="2" valign="top" class="odd"><b>&ensp;General&ensp;</b></td>
									<td class="titulo">PJ</td>
									<td class="titulo">PG</td>
									<td class="titulo">PE</td>
									<td class="titulo">PP</td>
									<td class="titulo">GA</td>
									<td class="titulo">GR</td>
									<td class="titulo">GD</td>
									<td class="titulo">PTS</td>
								</tr>
								<tr class="normal">
									<td>'.$fila_est['PAR_JUG_ACU'].'</td>
									<td>'.$fila_est['PAR_GAN_ACU'].' </td>
									<td>'.$fila_est['PAR_EMP_ACU'].' </td>
									<td>'.$fila_est['PAR_PER_ACU'].' </td>
									<td>'.$fila_est['GOL_ANO_ACU'].' </td>
									<td>'.$fila_est['GOL_RES_ACU'].' </td>
									<td>'.$fila_est['GD_ACU'].' </td>
									<td>'.$fila_est['PTS_ACU'].' </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table align="center" class="tabla_prin">
								<tr>
									<td align="center" rowspan="2" valign="top" class="odd"><b>&ensp;Titulos&ensp;</b></td>
									<td class="titulo" align="center">&ensp;Copa rotativa&ensp;</td>
									<td class="titulo" align="center">&ensp;Mejor ofensiva&ensp;</td>
									<td class="titulo" align="center">&ensp;Menos batido&ensp;</td>
									<td class="titulo" align="center">&ensp;Mas Disiplinado&ensp;</td>
									<td class="titulo" align="center">&ensp;RECOPA&ensp;</td>
								</tr>
								<tr class="normal">
									<td align="center">';
										$str_copa="";
										if($fila_est['POSICION']==1){
											$str_copa="Campeon";
										}
										else if($fila_est['POSICION']==2){
											$str_copa="Subcampeon";
										}
										else if($fila_est['POSICION']==3){
											$str_copa="Tercer lugar";
										}
										else if($fila_est['POSICION']==3){
											$str_copa="Cuarto lugar";
										}
										else{
											$str_copa=" - ";
										}
										echo $str_copa.'
									</td>
									<td align="center">';
										$str_m_o="";
										if($fila_est['PR_MEJ_OFEN']){
											$str_m_o="Si";
										}
										else{
											$str_m_o=" - ";
										}
										echo $str_m_o.'
									</td>
									<td align="center">';
										$str_m_b="";
										if($fila_est['PR_MEN_BATIDO']){
											$str_m_b="Si";
										}
										else{
											$str_m_b=" - ";
										}
										echo $str_m_b.' 
									</td>
									<td align="center">';
										$str_m_d="";
										if($fila_est['PR_MAS_DISC']){
											$str_m_d="Si";
										}
										else{
											$str_m_d=" - ";
										}
										echo $str_m_d.' 
									</td>
									<td align="center">';
										$str_recopa="";
										if($fila_est['PR_CAM_RECOPA']){
											$str_recopa="Si";
										}
										else{
											$str_recopa=" - ";
										}
										echo $str_recopa.' 
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table align="center" class="tabla_prin">
								<tr>
									<td align="center" rowspan="2" valign="top" class="odd"><b>&ensp;Disciplina&ensp;</b></td>
									<td class="titulo" align="center">&ensp;Tarjetas Amarillas Jugadores&ensp;</td>
									<td class="titulo" align="center">&ensp;Tarjetas Amarillas Equipo&ensp;</td>
									<td class="titulo" align="center">&ensp;Tarjetas Rojas&ensp;</td>
									<td class="titulo" align="center">&ensp;Total de tarjetas * &ensp;</td>
								</tr>
								<tr class="normal">
									<td align="center">
										<p align="center">'.$taramajug.'</p>
									</td>
									<td align="center">
										<p align="center">'.$taramaequi.'</p>
									</td>
									<td>
										<p align="center">'.$tarrojjug.'</p>
									</td>
									<td align="center"> 
										<p align="center">'.$totaltar.'</p>
									</td>
								</tr>
							</table>
						</td>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>';
				}
				?>
			</table>
			<?php 
			}
			else{
				echo '
				<table width="100%" border="0" align="center">
					<tr>
						<td>No se encontran registros del equipo</td>
    				</tr>
				</table>';
			}
			echo '<p align="center">(*) El total de tarjetas es expresado en tarjetas amarillas. Cada tarjeta roja equivale a 3 tarjetas amarillas.</p>';
			?>
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