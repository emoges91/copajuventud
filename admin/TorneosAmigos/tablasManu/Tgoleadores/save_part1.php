<?php
  include('../../conexiones/conec_cookies.php');
  $gol_temp='0';
  
 if(is_numeric($_POST['goles'])and is_numeric($_POST['jornada']))
 {
  if (
	(isset($_POST['jornada']) and ($_POST['jornada'] !='')) and
	 (isset($_POST['goles']) and ($_POST['goles'] !='')))
	 {
		 if($_POST['total_goles']!='')
		 {
		  $guardar_goles=$_POST['total_goles'].$_POST['goles'].';';
		  $guardar_jornada=$_POST['total_jornadas'].$_POST['jornada'].';';
		 }
		 else
		 {
			 $guardar_goles=$_POST['goles'].';';
			 $guardar_jornada=$_POST['jornada'].';';
		 }
		 
		  for($i=0;$i<=strlen($guardar_goles);$i++)
			  {
				  $compara=substr($guardar_goles,$i,1);
				  if($compara!=';')
				 {
				 $gol_temp=$gol_temp+$compara;
				 }
				 
			  } 
			  $stj=strlen($guardar_jornada);
	
	$sql = "UPDATE T_GOL_AMI SET
			NOMBRE = '".$_POST['nombre']."',
			APELLIDO1 = '".$_POST['apellido1']."',
			APELLIDO2='".$_POST['apellido2']."',
			EQUIPO = '".$_POST['equipo']."',
			GOLES = '".$guardar_goles."',
			JORNADAS = '".$guardar_jornada."',
			TG = '".$gol_temp."',
			STJ = '".$stj."',
			ID_TORNEO = '".$_POST['id_torneo']."'
			WHERE ID = '".$_POST['id']."'";
			
	
	$query = mysql_query($sql, $conn)or die(mysql_error());
		echo "<script type=\"text/javascript\">
			alert('Datos Registrados Correctamente');
			document.location.href='tabla_goleadores.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';
		</script>";
		
	 }
	 else
	 {
		echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>"; 
	 }
 }
 else
 {
	 echo "<script type=\"text/javascript\">alert('Insertar datos numericos unicamente');history.go(-1);</script>"; 
 }
?>