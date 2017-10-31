<?php
include('../../conexiones/conec_cookies.php');

$i=1;
$flag=0;
while($i<=$_POST['CAN_GRU']){
	$nombre_grupo="h_grupo".$i;
	if (!(isset($_POST[$nombre_grupo])and $_POST[$nombre_grupo] != '')){
		$flag=1;
	}
	$i++;
}

/// validar si se cumplen con los requisitos
if ((isset($_POST['HidNomb'])and $_POST['HidNomb'] != '')	
	and (isset($_POST['CAN_GRU']) and $_POST['CAN_GRU'] != '')
	and($_POST['CAN_GRU'] > 0) 
	and($flag==0)){
	
	//------------consultar si existe un torneo con el mismo nombre----------------
	$sql_torneo="Select ID from t_torneo where NOMBRE='".$_POST['HidNomb']."'";
	$query_torneo = mysql_query($sql_torneo, $conn);	
	$Consultar_Torneo =mysql_fetch_assoc($query_torneo);
	
	if(trim($Consultar_Torneo['ID'])==''){
	
		//---------------------------crear el nuevo torneo-----------
		$sql_torneo = "INSERT INTO t_torneo(NOMBRE,ACTUAL,INSTANCIA)  VALUES ('".$_POST['HidNomb']."',2,1)";
		$query_torneo = mysql_query($sql_torneo, $conn);
		
		if( mysql_insert_id() != 0){
			//----------------------------seleccionar el id del nuevo torneo-------
			$IDTorneo = mysql_insert_id();
		
			//---------------------se crea los diferentes eventos-----------
			$sql="insert into t_eventos(NOMBRE,ID_TORNEO,TIPO) VALUES('Llaves',".$IDTorneo.",2);";
			$query_llaves = mysql_query($sql, $conn);
			$sql="insert into t_eventos(NOMBRE,ID_TORNEO,TIPO) VALUES('Grupos',".$IDTorneo.",1);";
			$query_grupos = mysql_query($sql, $conn);
			
			if( mysql_insert_id() != 0){
				//----------------------------se elige el id del eventos grupo que se creo anteriormente------------
				$IDEventoGrupos = mysql_insert_id();
				
				$i=1;//contador para los grupos
				while($i<=$_POST['CAN_GRU']){
					$nombre_grupo="h_grupo".$i;//seleccionar el hidden del grupo
					$elementos=explode(',',$_POST[$nombre_grupo]);//dividir el string de equipos del hidden del grupo
					$nro_elementos=count($elementos);// cantidad de equipos en el grupo
					
					$j=0;// contador para los equipos
					while($j<$nro_elementos){
						//----------------------------------------insertar equipos-----------------------------------------------------------
						$sql_equipo="INSERT INTO t_equipo(NOMBRE,ACTIVO) VALUES ('".$elementos[$j]."',1)";
						$query=mysql_query($sql_equipo, $conn);
						$IDEquipo = mysql_insert_id();
						
						//---------------------------se establece la relacion entre los equipos y eventos-----
						$sql_Even_Equip="INSERT INTO t_even_equip(NUM_GRUP,ID_EQUI,ID_EVEN) VALUES (".$i.",".$IDEquipo.",".$IDEventoGrupos.")";
						$query=mysql_query($sql_Even_Equip, $conn);
						
						//-------------------------------------se crea las estadisticas de los equipos-----------
						$sql_Est_Equi="INSERT INTO t_est_equi(ID_EQUI,ID_TORNEO,PAR_JUG,PAR_GAN,PAR_EMP,PAR_PER,GOL_ANO,GOL_RES,PTS,PAR_JUG_ACU,
										PAR_GAN_ACU,PAR_EMP_ACU,PAR_PER_ACU,GOL_ANO_ACU,GOL_RES_ACU,PTS_ACU,POSICION) 
										VALUES (".$IDEquipo.",".$IDTorneo.",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
						$query=mysql_query($sql_Est_Equi, $conn);
						
						$j++;
					}
					$i++;
				}
				
				
				// msg de exito	
				echo "<script type=\"text/javascript\">
							alert('Torneo creado correctamente');
							document.location.href='../../index.php';
						</script>";
			}
			else{
				
				$sql="DELETE FROM t_eventos where ID_TORNEO=".$IDTorneo;
				$query_llaves = mysql_query($sql, $conn);
				
				$sql_torneo = "DELETE FROM t_torneo WHERE ID =".$IDTorneo;
				$query_torneo = mysql_query($sql_torneo, $conn);
				
				// error en crear grupos
				echo "<script type=\"text/javascript\">
						alert('Problemas al crear los grupos.');
						history.go(-1);
					</script>";
			}
		}
		else{
			$sql_torneo = "DELETE FROM t_torneo WHERE ID =".$IDTorneo;
			$query_torneo = mysql_query($sql_torneo, $conn);
			//error en crear torneo
			echo "<script type=\"text/javascript\">
					alert('Problemas al crear el torneo');
					history.go(-1);
			</script>";
		}
	}
	else{
		echo "<script type=\"text/javascript\">
				alert('Existe un Torneo con el mismo nombre.');
				history.go(-1);
			</script>";
	}
	
}
else{
	echo "<script type=\"text/javascript\">
			alert('Se debe de digitar un nombre al Torneo y agregar minimo un grupo.');
			history.go(-1);
	</script>";
}
?>