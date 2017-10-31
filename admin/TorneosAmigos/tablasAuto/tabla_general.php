<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" />
<?php
include('../conexiones/conec_cookies.php');
$dire='../';
include_once('../mostrar_torneo.php');

/*archivos original*****************************************************************************************************/	
$cadena_equi="SELECT *,(t_est_equi.GOL_ANO_ACU-t_est_equi.GOL_RES_ACU)as GD FROM t_est_equi
			LEFT JOIN t_equipo ON t_est_equi.ID_EQUI=t_equipo.ID
			WHERE t_est_equi.ID_TORNEO=".$_GET['ID']." 
			ORDER BY t_est_equi.POSICION ASC,t_est_equi.PTS_ACU DESC,GD DESC,GOL_ANO_ACU DESC;";
$consulta_equipos = mysql_query($cadena_equi, $conn);
?>			
<table cellpadding="0" cellspacing="1" class="tabla">
	<tr>
       	<td colspan="10" id="titulo" align="center">Tabla General Acumulada</td>
	</tr>
   	<tr>
		<th> Po. </td>
		<th> Equipos </td>
		<th> PJ </td>
		<th> PG </td>
		<th> PE </td>
		<th> PP </td>
		<th> GA </td>
		<th> GR </td>
		<th> GD </td>
		<th style="border-right:1px solid #ddd;"> PTS </td>
	</tr>
<?php
$num=1;
if($consulta_equipos==''){
	$cant=0;
}
else{
	$cant = mysql_num_rows($consulta_equipos);
}

if($cant>0){
	while($fila_equi=mysql_fetch_assoc($consulta_equipos)){
		echo '
		<tr>
			<td>'.$num++.'</td>
			<td>'.$fila_equi['NOMBRE'].'</td>
			<td>'.$fila_equi['PAR_JUG_ACU'].'</td>
			<td>'.$fila_equi['PAR_GAN_ACU'].'</td>
			<td>'.$fila_equi['PAR_EMP_ACU'].'</td>
			<td>'.$fila_equi['PAR_PER_ACU'].'</td>
			<td>'.$fila_equi['GOL_ANO_ACU'].'</td>
			<td>'.$fila_equi['GOL_RES_ACU'].'</td>
			<td>'.$fila_equi['GD'].'</td>
			<td style="border-right:1px solid #ddd;">'.$fila_equi['PTS_ACU'].'</td>
		</tr>';
	}
}
else{
?>
		<tr>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td>&ensp;</td>
			<td style="border-right:1px solid #ddd;">&ensp;</td>
		</tr>
<?php
}
?>
	</table>