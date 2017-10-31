<?php
include('../../conexiones/conec_cookies.php');

include_once('../../FPHP/funciones.php');

for($i=1;$i<=$_POST['total_partidos'];$i++){
	if(comprobar_fecha($_POST['piker_'.$i])==0 || trim($_POST['piker_'.$i])==''){
		$flag=1;
	}
}

if(($flag==0)){	
	//condicion que evalua si se procede a guardar
	for($i=1;$i<=$_POST['total_partidos'];$i++){
		$hora='TXT_hora'.$i;
		$cancha='TXT_cancha'.$i;
		$fecha='piker_'.$i;
		$id_partido='hdn_idPartido'.$i;
		
		//CONSULTAR la el partido
		$str_consulta="SELECT * FROM t_jornadas 
			WHERE ID=".$_POST[$id_partido];
		$consulta = mysql_query($str_consulta, $conn)or die(mysql_error());
		$partido=mysql_fetch_assoc($consulta);
	
		$str_mod_prox_jor="UPDATE t_jornadas SET
			FECHA='".cambiaf_a_mysql($_POST[$fecha])."',
			HORA='".$_POST[$hora]."',
			CANCHA='".$_POST[$cancha]."'
			WHERE ID=".$_POST[$id_partido];
		$consulta_mod_prox_jor = mysql_query($str_mod_prox_jor, $conn)or die(mysql_error());
	}
		echo "<script type=\"text/javascript\">
			alert('El nombre de las canchas, fecha y horas de los partidos de la jornada seleccionada fueron cambiados.');
			document.location.href='../ingr_cancha_fecha.php?NUM_JOR=".$_POST['HidNumJor']."&ID=".$_POST['HidTorneo']."&NOMB=".$_POST['HidNomb']."&TIPO=".$_POST['HidTipo']."';
		</script>";
}
else{
	echo "
	<script type=\"text/javascript\">
		alert('EL formato de la fecha DD/MM/YYYY');
		history.go(-1);
	</script>";
}
?>