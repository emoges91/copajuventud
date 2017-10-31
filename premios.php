<?php
include('admin/conexiones/conec.php');

function cambiaf_a_normal($fecha){
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	return $lafecha;
}

$cadena = "SELECT * FROM T_TORNEO WHERE ACTUAL=1";
$consulta_torneo= mysql_query($cadena, $conn);
$fila=mysql_fetch_assoc($consulta_torneo);
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
   		<?php     	
		if($cant_tor>0){	
		//obterner evento de grupos
		$sql_grupos = "SELECT * FROM T_EVENTOS WHERE ID_TORNEO=".$fila['ID']." and TIPO=1";
		$query_grupos = mysql_query($sql_grupos, $conn);
		$row_grupos=mysql_fetch_assoc($query_grupos);

		//obtener el evento de llaves
		$sql_llave = "SELECT * FROM T_EVENTOS WHERE ID_TORNEO=".$fila['ID']." and TIPO=2";
		$query_llave = mysql_query($sql_llave, $conn);
		$row_llave=mysql_fetch_assoc($query_llave);
		
		//obtener el evento de recopa
		$sql = "SELECT * FROM T_EVENTOS WHERE ID_TORNEO=".$fila['ID']." and TIPO=3";
		$query = mysql_query($sql, $conn);
		$row=mysql_fetch_assoc($query);
		
		
		//obtener el equipo campeon copa rotativa
		$sql_posicion="SELECT *,(t_equipo.ID)AS ID_EQUI FROM T_EVEN_EQUIP
				LEFT JOIN t_equipo ON T_EVEN_EQUIP.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE T_EVEN_EQUIP.ID_EVEN=".$row_llave['ID'].' AND t_est_equi.ID_TORNEO='.$fila['ID'].' AND t_est_equi.POSICION=1 
				ORDER BY t_est_equi.POSICION ASC LIMIT 0,4';
		$query_posicion = mysql_query($sql_posicion, $conn);
		
		//obtener el equipo menos batido
		$sql_m_bat="SELECT *,(t_equipo.ID)AS ID_EQUI FROM T_EVEN_EQUIP
				LEFT JOIN t_equipo ON T_EVEN_EQUIP.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE T_EVEN_EQUIP.ID_EVEN=".$row_llave['ID'].' AND t_est_equi.PR_MEN_BATIDO=1  AND t_est_equi.ID_TORNEO='.$fila['ID'];
		$query_m_bat = mysql_query($sql_m_bat, $conn);

		//obtener el equipo con mejor ofensiva
		$sql_m_ofe="SELECT *,(t_equipo.ID)AS ID_EQUI FROM T_EVEN_EQUIP
				LEFT JOIN t_equipo ON T_EVEN_EQUIP.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE T_EVEN_EQUIP.ID_EVEN=".$row_llave['ID'].' AND t_est_equi.PR_MEJ_OFEN=1  AND t_est_equi.ID_TORNEO='.$fila['ID'];
		$query_m_ofe = mysql_query($sql_m_ofe, $conn);
	
		//obtener el equipo mas disiplinado
		$sql_m_disc="SELECT *,(t_equipo.ID)AS ID_EQUI FROM T_EVEN_EQUIP
				LEFT JOIN t_equipo ON T_EVEN_EQUIP.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE T_EVEN_EQUIP.ID_EVEN=".$row_grupos['ID'].' AND t_est_equi.PR_MAS_DISC=1 AND t_est_equi.ID_TORNEO='.$fila['ID'];
		$query_m_disc = mysql_query($sql_m_disc, $conn);

		//campeon recopa
		$sql_recopa="SELECT *,(t_equipo.ID)AS ID_EQUI FROM T_EVEN_EQUIP
				LEFT JOIN t_equipo ON T_EVEN_EQUIP.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE T_EVEN_EQUIP.ID_EVEN=".$row_llave['ID'].' AND t_est_equi.PR_CAM_RECOPA=1 AND t_est_equi.ID_TORNEO='.$fila['ID'];
		$query_recopa = mysql_query($sql_recopa, $conn);

		$sql_goleador="SELECT *,(T_PERSONAS.NOMBRE)AS NOM_JUG,(T_PERSONAS.ID)AS ID_JUG FROM T_EST_JUG
			LEFT JOIN T_PERSONAS ON T_EST_JUG.ID_PERSONA=T_PERSONAS.ID
			WHERE T_EST_JUG.ID_TORNEO=".$fila['ID'].' AND T_EST_JUG.PR_GOL=1';
		$consulta_goleador= mysql_query($sql_goleador, $conn);

		echo '
		<table align="center" >
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr align="center">
				<td>
					<font face="Comic Sans MS, cursive" size="+2" color="#0066CC">'.$fila['NOMBRE'].' '.$fila['YEAR'].'</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr align="center">
				<td>
					<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif" size="+1">Premios</font>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>';

		echo'
		<table align="center" cellpadding="0" cellspacing="0" width="600px">
			<tr >
				<td>
					<table>';	
						echo'	
						<tr>
							<td><b>Campeon:</b></td>
							<td>';$row_posicion=mysql_fetch_assoc($query_posicion);
								echo ''.$row_posicion['NOMBRE'].'</td>
						</tr>';
					echo'
					</table>
				</td>
			</tr>
			<tr bgcolor="#eefeee">
				<td><b>Arco Menos Batido:</b></td>
				<td>';$row_m_bat=mysql_fetch_assoc($query_m_bat);echo ' '.$row_m_bat['NOMBRE'].'</td>
			</tr>
			<tr >
				<td><b>Mejor Ofensiva:</b></td>
				<td>';$row_m_ofe=mysql_fetch_assoc($query_m_ofe);echo ' '.$row_m_ofe['NOMBRE'].' </td>
			</tr>
			<tr bgcolor="#eefeee">
				<td><b>Mas Diciplinado:</b></td>
				<td>';$row_m_disc=mysql_fetch_assoc($query_m_disc);echo ' '.$row_m_disc['NOMBRE'].'</td>
			</tr>
			<tr >
				<td>
					<table>
						<tr>
							<td><b>Goleador:</b></td>
							<td>';$row_goleador=mysql_fetch_assoc($consulta_goleador);
							echo ' '.$row_goleador['NOMBRE'].' '.$row_goleador['APELLIDO1'].' '.$row_goleador['APELLIDO2'].'</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor="#eefeee">
				<td><b>Campeon '.$row['NOMBRE'].':</b></td>
				<td>';$row_recopa=mysql_fetch_assoc($query_recopa);echo ' '.$row_recopa['NOMBRE'].' </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>';
		}
else{
	echo '
			<table align="center">
				<tr>
					<td>El torneo no se encuentra registrado</td>
				</tr>
			</table>';
}
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