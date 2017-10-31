<?php
	include('conexiones/conec_cookies.php');
	
	$control=0;
	$sql=  "SELECT * FROM t_personas
	LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
	WHERE t_personas.ID_EQUI = ".$_GET['id']." and t_car_per.CARGO='Jugador'";
	$query= mysql_query($sql,$conn);
	$cant= mysql_num_rows($query);
	
	if($cant>0){
		$control=1;
	}
	
	$sql=  "SELECT * FROM t_personas 
	LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
	WHERE t_personas.ID_EQUI = ".$_GET['id']." and t_car_per.CARGO='Director Tecnico'";	
	$query= mysql_query($sql,$conn);
	$cant= mysql_num_rows($query); 
	if($cant>0)
	{
		$control=1;
	}
	$sql=  "SELECT * FROM t_personas 
	LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
	WHERE t_personas.ID_EQUI = ".$_GET['id']." and t_car_per.CARGO='Asistente'";	
	$query= mysql_query($sql,$conn);
	$cant= mysql_num_rows($query); 
	if($cant>0)
	{
	$control=1;
	}
	$sql=  "SELECT * FROM t_personas 
	LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
	WHERE t_personas.ID_EQUI = ".$_GET['id']." and t_car_per.CARGO='Representante'";	
	$query= mysql_query($sql,$conn);
	$cant= mysql_num_rows($query); 
	if($cant>0)
	{
		$control=1;
	}			
	$sql=  "SELECT * FROM t_personas
	LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
	WHERE t_personas.ID_EQUI = ".$_GET['id']." and t_car_per.CARGO='Suplente'";	
	$query= mysql_query($sql,$conn);
	$cant= mysql_num_rows($query); 	
	if($cant>0)
	{
		$control=1;
	}
	if ($control==0)
	{
		$sql="UPDATE t_equipo SET ACTIVO=0 WHERE ID=".$_GET['id'];
		$query=mysql_query($sql,$conn);	
		
		echo "<script type=\"text/javascript\">
		alert('El equipo fue desactivado con exito');
		document.location.href='index.php';
		</script>";
	}
	else
	{
		echo"<script type=\"text/javascript\">
		alert('El equipo no se puede desactivar debe de desactivar a todas las personas');
		history.go(-1);
		</script>";	
	}
?>
