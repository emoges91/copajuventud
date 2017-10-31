<?php
include('../../conexiones/conec_cookies.php');
if (is_numeric($_POST['amarillas'])and is_numeric($_POST['rojas']))
{
	$guarda_amarillas=$_POST['amarillas_temp'].$_POST['amarillas'].';';
	$guarda_rojas=$_POST['rojas_temp'].$_POST['rojas'].';';
	$guarda_jornadas=$_POST['jornadas_temp'].$_POST['jornadas'].';';
	$sta=strlen($guarda_jornadas);
	
	 for($i=0;$i<=strlen($guarda_amarillas);$i++)
			  {
				  $compara=substr($guarda_amarillas,$i,1);
				  if($compara!=';')
				 {
				 $tta=$tta+$compara;
				 } 
			  } 
		
		
	$sql = "UPDATE T_CON_DIS_AMI SET
			NOMBRE_EQUI = '".$_POST['nombre_equi']."',
			JORNADAS = '".$guarda_jornadas."',
			AMARILLAS='".$guarda_amarillas."',
			ROJAS = '".$guarda_rojas."',
			TTA = '".$tta."',
			STA = '".$sta."',
			ID_TORNEO='".$_POST['id_torneo']."'
			WHERE ID = '".$_POST['id']."'";
			
	$query = mysql_query($sql, $conn)or die(mysql_error());
		echo "<script type=\"text/javascript\">
			alert('Datos Registrados Correctamente');
			document.location.href='ctrl_disc.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';
		</script>";
	
	
	
}
else
{
	echo "<script type=\"text/javascript\">alert('Insertar datos numericos unicamente');history.go(-1);</script>"; 
}
?>