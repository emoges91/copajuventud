<?php
include('conexiones/conec_cookies.php');
$bandera=0;
if ((isset($_POST['CED'])and $_POST['CED'] != '') 
	and (isset($_POST['NOMBRE']) and $_POST['NOMBRE'] != '')
    and (isset($_POST['APELLIDO1']) and $_POST['APELLIDO1'] != '') 
	and (isset($_POST['APELLIDO2']) and $_POST['APELLIDO2'] != '') 
	and (isset($_POST['DIR']) and $_POST['DIR'] != '') 
	and(isset($_POST['EQUIPO'])and $_POST['EQUIPO']!=''))
{
	$sql="select CED from t_personas where CED='".$_POST['CED']."'";
    $VER= mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($VER))
	{
	if($_POST['CED']==$row['CED'])
	  {
		  $bandera=1;
	  }
	}
	if($bandera==0)
	{
	if((isset($_POST['JUGADOR'])and $_POST['JUGADOR'] != '')
	or(isset($_POST['DT'])and $_POST['DT'] != '')
	or(isset($_POST['ASISTENTE'])and $_POST['ASISTENTE'] != '')
	or(isset($_POST['REPRESENTANTE'])and $_POST['REPRESENTANTE'] != '')
	or(isset($_POST['SUPLENTE'])and $_POST['SUPLENTE'] != '') )
	{
		
		$cadena_jugadores=  "SELECT * FROM t_personas 
		LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
		WHERE t_personas.ID_EQUI = ".$_POST['EQUIPO']." AND t_car_per.CARGO='Jugador'";
		
		$cadena_dt=  "SELECT * FROM t_personas 
		LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
		WHERE t_personas.ID_EQUI = ".$_POST['EQUIPO']." AND t_car_per.CARGO='Director Tecnico'";
		
		$cadena_asistente=  "SELECT * FROM t_personas 
		LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
		WHERE t_personas.ID_EQUI = ".$_POST['EQUIPO']." AND t_car_per.CARGO='Asistente'";
		
		$cadena_repre=  "SELECT * FROM t_personas 
		LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
		WHERE t_personas.ID_EQUI = ".$_POST['EQUIPO']." AND t_car_per.CARGO='Representante'";
		
		$cadena_suplente=  "SELECT * FROM t_personas 
		LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
		WHERE t_personas.ID_EQUI = ".$_POST['EQUIPO']." AND t_car_per.CARGO='Suplente'";
		
		$consulta_jugadores= mysql_query($cadena_jugadores,$conn);
		$consulta_dt= mysql_query($cadena_dt,$conn);
		$consulta_asistente= mysql_query($cadena_asistente,$conn);
		$consulta_repre= mysql_query($cadena_repre,$conn);
		$consulta_suplente= mysql_query($cadena_suplente,$conn);
		$total_jugadores= mysql_num_rows($consulta_jugadores);
		$total_dt= mysql_num_rows($consulta_dt);
		$total_asistente= mysql_num_rows($consulta_asistente);
		$total_repre= mysql_num_rows($consulta_repre);
		$total_suplete= mysql_num_rows($consulta_suplente);
		
		if(!(isset($_POST['JUGADOR'])and $_POST['JUGADOR'] != '')){	 
		$total_jugadores=0;
		}
		if($total_jugadores<22){
			
			if(!(isset($_POST['DT'])and $_POST['DT'] != '')){	
			$total_dt=0;
			}
			if($total_dt<1){
			
				if(!(isset($_POST['ASISTENTE'])and $_POST['ASISTENTE'] != '')){	
				$total_asistente=0;
				}
				if($total_asistente<5){
					
					if(!(isset($_POST['REPRESENTANTE'])and $_POST['REPRESENTANTE'] != '')){	
						$total_repre=0;
					}
					if($total_repre<1){

						if(!(isset($_POST['SUPLENTE'])and $_POST['SUPLENTE'] != '')){	
							$total_suplete=0;
						}
						if($total_suplete<1){
			
	  							if ($_POST['ACTIVO']==true){
									$act=1;}
  								else{
									$act=0;}
	 							$sql = "INSERT INTO t_personas VALUES (null, 
											'".$_POST['CED']."', 
											'".$_POST['NOMBRE']."', 
											'".$_POST['APELLIDO1']."',
											'".$_POST['DIR']."',
											'".$_POST['TEL']."',
											'".$act."',
											'".$_POST['EQUIPO']."',
											'".$_POST['APELLIDO2']."')";
			 					$query = mysql_query($sql, $conn);
	
	
								$sql = "SELECT ID FROM t_personas WHERE CED='".$_POST['CED']."'  AND ID_EQUI=".$_POST['EQUIPO'];
								$queryid = mysql_query($sql, $conn);
								$row=mysql_fetch_assoc($queryid);
	
								if((isset($_POST['JUGADOR'])and $_POST['JUGADOR'] != '')){	 
	 							$sql = "INSERT INTO t_car_per VALUES (null,'".$row['ID']."','Jugador')";
	 							$query = mysql_query($sql, $conn);
								}		
	
								if((isset($_POST['DT'])and $_POST['DT'] != '')){	 
			 					$sql = "INSERT INTO t_car_per VALUES (null,'".$row['ID']."','Director Tecnico')";
	 					     	$query = mysql_query($sql, $conn);
								}
	
								if((isset($_POST['ASISTENTE'])and $_POST['ASISTENTE'] != '')){	 
	 							$sql = "INSERT INTO t_car_per VALUES (null,'".$row['ID']."','Asistente')";
	 							$query = mysql_query($sql, $conn);
								}
	
								if((isset($_POST['REPRESENTANTE'])and $_POST['REPRESENTANTE'] != '')){	 
	 							$sql = "INSERT INTO t_car_per VALUES (null,'".$row['ID']."','Representante')";
								$query = mysql_query($sql, $conn);
								}	

								if((isset($_POST['SUPLENTE'])and $_POST['SUPLENTE'] != '')){	 
	 							$sql = "INSERT INTO t_car_per VALUES (null, '".$row['ID']."','Suplente')";
	 							$query = mysql_query($sql, $conn);
								}

   								echo "<script type=\"text/javascript\">
   										alert('Persona registrada correctamente');
   										document.location.href='torneo_jugadores.php?id=".$_POST['EQUIPO']."';
									</script>";
						
						}
						else{
							echo "<script type=\"text/javascript\">
								alert('El suplente del representante tecnico ya fue ingresado');
								history.go(-1);
							</script>";
						}
					
					}
					else{
					echo "<script type=\"text/javascript\">
							alert('El representante tecnico ya fue ingresado');
							history.go(-1);
						</script>";
					}
					
				}
				else{
					echo "<script type=\"text/javascript\">
						alert('La lista de los asistentes del cuerpo tecnico ya esta completa ');
						history.go(-1);
					</script>";
				}
			}
			else{
				echo "<script type=\"text/javascript\">
					alert('El director tecnico ya fue ingresado ');
					history.go(-1);
				</script>";
			}
		}
		else{
			echo "<script type=\"text/javascript\">
				alert('Lista de jugadores completa');
				history.go(-1);
			</script>";
		}
	}
	else
	{
		echo "<script type=\"text/javascript\">
				alert('Debe de eligir un cargo por lo menos');
				history.go(-1);
			</script>";
	}
}

else
{
	echo "<script type=\"text/javascript\">
			alert('Cedula repetida...Por favor verifique!!!');
			history.go(-1);
		</script>";
}
}
else
{
	
	echo "<script type=\"text/javascript\">
			alert('Los campos con asterisco (*) son requeridos');
			history.go(-1);
		</script>";
}
?>


