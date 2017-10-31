<script>
function mouse_arriba(elemento){
	
	var trElemnto=document.getElementById(elemento);
	elemento.style.color="#956c1a";
}
function mouse_fuera(elemento){
	
	var trElemnto=document.getElementById(elemento);
	elemento.style.color="#000000";
}
</script>
<?php
include('admin/conexiones/conec.php');

?>
<!-- Save for Web Slices (otro2.psd) -->
<table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
		<td colspan="3" style="background:url(img/img_ami/amigos1.png) no-repeat; width:1062px; height:7px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ami/amigos2.png) #000 no-repeat;  width:14px; height:284px;">
			</td>
		<td style="background:url(img/img_ami/amigos3.png) #000 no-repeat; width:1035px; height:284px;" valign="top">
        <link rel="stylesheet" href="css/tabla_estilo.css" type="text/css" />
<?php

function cambiaf_a_normal($fecha){
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	return $lafecha;
}

//consultar el torneo recien creado
$sql_torneo_cons="SELECT * FROM t_tor_amigo
				WHERE ID=". $_GET['id'];				
$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);
$fila_torneo_con=mysql_fetch_assoc($query_torneo_cons);

$sql_est="SELECT * FROM t_est_amigos 
			WHERE ID_TORNEO=".$fila_torneo_con['ID'];
$query_est=mysql_query($sql_est, $conn);

$sql_jor="SELECT * FROM t_jor_amigos
		WHERE ID_TORNEO=".$fila_torneo_con['ID'];
$query_jor=mysql_query($sql_jor, $conn);

if($fila_torneo_con['ESTADO']==1){
	$var_estado='checked';
}

if($fila_torneo_con['ESTADO']==1){
	$estado="Activo";
}
else{
	$estado="Inactivo";
}
	
echo'
<table align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr style="color:#ffffff;">
		<td colspan="9" align="center">&ensp;Torneo:'.$fila_torneo_con['NOMBRE'].'&ensp;</td>
	</tr>
	<tr>
		<td colspan="9">&nbsp;</td>
	</tr>
</table>
<table align="center" cellpadding="0" cellspacing="0" width="866px"  class="tabla_prin">
	<tr>
		<td class="cabeza_jug" colspan="9" align="center">&ensp;Tabla&ensp;</td>
	</tr>
	<tr id="titulo" style="color:#eee;">
		<td width="30px">&ensp;Po.&ensp;</td>
		<td align="center">&ensp;Equipo&ensp;</td>
		<td>&ensp;PJ&ensp;</td>
		<td>&ensp;PG&ensp;</td>
		<td>&ensp;PE&ensp;</td>
		<td>&ensp;PP&ensp;</td>
		<td>&ensp;GA&ensp;</td>
		<td>&ensp;GR&ensp;</td>
		<td>&ensp;PTS&ensp;</td>
	</tr>';
$i=0;
$indi=0;
$clase="";	
while($fila_est=mysql_fetch_assoc($query_est)){
	$i++;
	
	if($indi==0){
		$clase=' class="normal"';
		$indi=1;
	}
	else{
		$clase=' class="odd"';
		$indi=0;
	}
		echo'	
	<tr '.$clase.' id="cuerpo" onmouseover="mouse_arriba(this);" onmouseout="mouse_fuera(this);">
		<td>&ensp;'.$i.'&ensp;</td>
		<td>&ensp;'.$fila_est['EQUIPO'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PJ'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PG'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PE'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PP'].'&ensp;</td>
		<td>&ensp;'.$fila_est['GA'].'&ensp;</td>
		<td>&ensp;'.$fila_est['GR'].'&ensp;</td>
		<td>&ensp;'.$fila_est['PTS'].'&ensp;</td>
	</tr>';
}
echo '
<tr class="pie">
    	<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>';

echo '
&nbsp;
<table align="center" cellpadding="0" cellspacing="0" width="866px" class="tabla_prin">
	<tr>
		<td colspan="6" align="center" class="caption">Ultima jornada</td>
	</tr>
	<tr id="titulo" style="color:#eee;">
		<td>&ensp;Equipos casa&ensp;</td>
		<td>&ensp;Marcador&ensp;</td>
		<td></td>
		<td>&ensp;Equipo visita&ensp;</td>
		<td>&ensp;Marcador&ensp;</td>
		<td>&ensp;Fecha&ensp;</td>
	</tr>
';

$i=0;
$indi=0;
$clase="";
while($fila_jor=mysql_fetch_assoc($query_jor)){
	$i++;
	if($indi==0){
		$clase=' class="normal"';
		$indi=1;
	}
	else{
		$clase=' class="odd"';
		$indi=0;
	}
		
	echo'
	<tr '.$clase.' id="cuerpo" onmouseover="mouse_arriba(this);" onmouseout="mouse_fuera(this);">
		<td>&ensp;'.$fila_jor['EQUI_CASA'].'&ensp;</td>
		<td>&ensp;'.$fila_jor['MARC_CASA'].'&ensp;</td>
		<td>Vrs</td>
		<td>&ensp;'.$fila_jor['EQUI_VIS'].'&ensp;</td>
		<td>&ensp;'.$fila_jor['MARC_VIS'].'&ensp;</td>
		<td>&ensp;'.cambiaf_a_normal($fila_jor['FECHA']).'&ensp;</td>
	</tr>
	';
}
echo'	
	<tr class="pie">
    	<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>';
?>

			</td>
		<td style="background:url(img/img_ami/amigos4.png) #000 no-repeat; width:13px; height:284px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ami/amigos2_07.png) #000 no-repeat; width:1062px; height:26px;">
			</td>
	</tr>
    <tr>
		<td colspan="3" style="background:url(img/img_ami/amigos6.png) no-repeat; width:1062px; height:43px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td style="background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;">      
<?php include('content_secundario.html');?>
			</td>
		<td style="background:url(img/img_ini/inicio_22.png) repeat-y; width:13px; height:66px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ini/inicio_23.png) no-repeat; width:1062px; height:18px;">
			</td>
	</tr>
</table>