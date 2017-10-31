<?php
include('../../conexiones/conec_cookies.php');
include_once('../../FPHP/funciones.php');


for($i=1;$i<=$_POST['total_jornadas'];$i++){
	$orden=$_POST['CbBPosicion'.$i];
	$cadenaid = trim($_POST['HidIdJornadas'.$i], ',');
	$elementos=explode(',',$cadenaid);//dividir el string de equipos del hidden del grupo
	$nro_elementos=count($elementos);// cantidad de equipos en el grupo
	
	$j=0;// contador para los equipos
	while($j<$nro_elementos){
		$str="UPDATE t_jornadas SET 
						NUM_JOR=".$orden."
				WHERE ID=".$elementos[$j];
		$query = mysql_query($str, $conn)or die(mysql_error());
		$j++;
	}
}

$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_POST['HidTorneo']." and TIPO=1";
$query = mysql_query($sql, $conn);
$row=mysql_fetch_assoc($query);

$str="UPDATE t_jornadas SET 
						ESTADO=0
			WHERE ID_EVE=".$row['ID']." AND NUM_JOR<>1";
		$query = mysql_query($str, $conn)or die(mysql_error());

$str="UPDATE t_jornadas SET 
						ESTADO=2
			WHERE ID_EVE=".$row['ID']." AND NUM_JOR=1";
		$query = mysql_query($str, $conn)or die(mysql_error());

echo "<script type=\"text/javascript\">
   		alert('Torneo creado correctamente');
		document.location.href='../jor_grupos.php?ID=".$_POST['HidTorneo']."&NOMB=".$_POST['HidNomb']."';
	</script>";
?>