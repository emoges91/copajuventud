<?php
include('../../conexiones/conec_cookies.php');

$str_jornada="SELECT * FROM t_jornadas
			WHERE t_jornadas.ID=".$_GET['ID_JOR'];
$consulta_jornada = mysql_query($str_jornada, $conn);
$fila_jornada=mysql_fetch_assoc($consulta_jornada);

if(trim($fila_jornada['MARCADOR_CASA'])==''){
	$fila_jornada['MARCADOR_CASA']='null';
}

if(trim($fila_jornada['MARCADOR_VISITA'])==''){
	$fila_jornada['MARCADOR_VISITA']='null';
}

$str_voltear="UPDATE t_jornadas SET 
ID_EQUI_CAS=".$fila_jornada['ID_EQUI_VIS'].",
ID_EQUI_VIS=".$fila_jornada['ID_EQUI_CAS'].",
MARCADOR_VISITA=".$fila_jornada['MARCADOR_CASA'].",
MARCADOR_CASA=".$fila_jornada['MARCADOR_VISITA']."
WHERE t_jornadas.ID=".$_GET['ID_JOR'];
$consulta_voltear = mysql_query($str_voltear, $conn);

echo "<script type=\"text/javascript\">
		document.location.href='../jor_llaves.php?ID=".$_GET['ID']."&NOMB=".$_GET['NOMB']."';
	</script>";
?>