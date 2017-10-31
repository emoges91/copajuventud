<?php
include('../../conexiones/conec_cookies.php');
//comprobar si se ingresaron los equipos y provar si son mas de dos

$flag=0;
if($_POST['txt_cant_fase']>0){
	for($i=1;$i<=$_POST['txtfase1'];$i++){
		
		$hidden_partido="h_partido_".$i."_1";	
		list($id_equipo_casa,$id_equipo_visita,$id_sobrante)=explode(',',$_POST[$hidden_partido]);
		
		if ( !(isset($_POST[$hidden_partido]))||($_POST[$hidden_partido] == '')||($id_sobrante!='') ){
			$flag=1;
		}	
	}
	
	for($i=1;$i<=$_POST['txt_cant_fase'];$i++){
		if ( $_POST['txtfase'.$i]<1){
			$flag=1;
		}
	}
}
else{
	$flag=1;
}
//fin de probar

//condicion para proceder a almacenar datos
if ((isset($_POST['txt_cant_fase']) and $_POST['txt_cant_fase'] != '')and($flag==0)){
	//------------consultar si existe un torneo con el mismo nombre----------------
	$sql_torneo="Select ID from t_torneo where NOMBRE='".$_POST['HidNomb']."'";
	$query_torneo = mysql_query($sql_torneo, $conn);	
	$Consultar_Torneo =mysql_fetch_assoc($query_torneo);
	
	if(trim($Consultar_Torneo['ID'])==''){

		//---------------------------crear el nuevo torneo-----------
		$sql_torneo = "INSERT INTO t_torneo(NOMBRE,ACTUAL,INSTANCIA)  VALUES ('".$_POST['HidNomb']."','2','2')";
		$query_torneo = mysql_query($sql_torneo, $conn);
		
		if( mysql_insert_id() != 0){
			//----------------------------seleccionar el id del nuevo torneo-------
			$IDTorneo = mysql_insert_id();
			
			//---------------------se crea los diferentes eventos-----------
			$sql="insert into t_eventos(NOMBRE,ID_TORNEO,TIPO) VALUES('Llaves',".$IDTorneo.",2);";
			$query_llaves = mysql_query($sql, $conn);
			
			if( mysql_insert_id() != 0){
				//----------------------------se elige el id del eventos grupo que se creo anteriormente------------
				$IDEventoLlaves = mysql_insert_id();		
	
				$total_fases=$_POST['txt_cant_fase'];
				$num_jornada=1;
				$num_grupo=0;
				
				for($a=1;$a<=$total_fases;$a++){
					for($i=1;$i<=$_POST['txtfase'.$a];$i++){	
						$num_grupo=$num_grupo+1;
						
						if($a==1){// cuando es la primera fase es necesario guardar los equipos	
							$nombre_grupo="h_partido_".$i."_1";// nombre del hidden que contiene los partidos de la 1 ronda(equipos separados por ,)
							list($id_equipo_casa,$id_equipo_visita)=explode(',',$_POST[$nombre_grupo]);//separar el equipo casa del visita
							
							//***************************************************************************************
							//----------------------------------------insertar equipo casa-----------------------------------------------------------
							$sql_equipo="INSERT INTO t_equipo(NOMBRE,ACTIVO) VALUES ('".$id_equipo_casa."',1)";
							$query=mysql_query($sql_equipo, $conn);
							$IDEquipoCasa = mysql_insert_id();
							
							//----------------------------------------insertar equipo visita-----------------------------------------------------------
							$sql_equipo="INSERT INTO t_equipo(NOMBRE,ACTIVO) VALUES ('".$id_equipo_visita."',1)";
							$query=mysql_query($sql_equipo, $conn);
							$IDEquipoVisita = mysql_insert_id();
							
							
							//***************************************************************************************
							//---------------------------se establece la relacion entre los equipo casa y el evento-----
							$sql_equi_casa="INSERT INTO t_even_equip(NUM_GRUP,ID_EQUI,ID_EVEN) VALUES (0,".$IDEquipoCasa.",".$IDEventoLlaves.")";
							$query=mysql_query($sql_equi_casa, $conn);
			
							//---------------------------se establece la relacion entre los equipo visita y el evento-----
							$sql_equi_visit="INSERT INTO t_even_equip(NUM_GRUP,ID_EQUI,ID_EVEN) VALUES (0,".$IDEquipoVisita.",".$IDEventoLlaves.")";
							$query=mysql_query($sql_equi_visit, $conn);
							
							
							//***************************************************************************************
							//-------------------------------------se crea las estadisticas de los equipos-----------
							$sql_Est_Equi="INSERT INTO t_est_equi(ID_EQUI,ID_TORNEO,PAR_JUG,PAR_GAN,PAR_EMP,PAR_PER,GOL_ANO,GOL_RES,PTS,PAR_JUG_ACU,
											PAR_GAN_ACU,PAR_EMP_ACU,PAR_PER_ACU,GOL_ANO_ACU,GOL_RES_ACU,PTS_ACU,POSICION) 
											VALUES (".$IDEquipoCasa.",".$IDTorneo.",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
							$query=mysql_query($sql_Est_Equi, $conn);
							
							$sql_Est_Equi="INSERT INTO t_est_equi(ID_EQUI,ID_TORNEO,PAR_JUG,PAR_GAN,PAR_EMP,PAR_PER,GOL_ANO,GOL_RES,PTS,PAR_JUG_ACU,
											PAR_GAN_ACU,PAR_EMP_ACU,PAR_PER_ACU,GOL_ANO_ACU,GOL_RES_ACU,PTS_ACU,POSICION) 
											VALUES (".$IDEquipoVisita.",".$IDTorneo.",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
							$query=mysql_query($sql_Est_Equi, $conn);
							
							
							//***************************************************************************************
							//---------------------------se guardar los partidos-----
							$sql_partido_llaves_casa="INSERT INTO t_jornadas(ID_EQUI_CAS,ID_EQUI_VIS,FECHA,ESTADO,NUM_JOR,ID_EVE,GRUPO) 
														VALUES (".$IDEquipoCasa.",".$IDEquipoVisita.",NULL,2,".$num_jornada.",".$IDEventoLlaves.",".$num_grupo.")";
							$query=mysql_query($sql_partido_llaves_casa, $conn);
							 
							if($a<>$total_fases){
								//---------------------------se guardar los partidos-----
								$sql_partido_llaves_visita="INSERT INTO t_jornadas(ID_EQUI_CAS,ID_EQUI_VIS,FECHA,ESTADO,NUM_JOR,ID_EVE,GRUPO) 
															VALUES (".$IDEquipoCasa.",".$IDEquipoVisita.",NULL,0,".($num_jornada+1).",".$IDEventoLlaves.",".$num_grupo.")";	
								$query=mysql_query($sql_partido_llaves_visita, $conn);
							}
						}
						else{// crear las demas jornadas pero vacias
							$sql_partido_llaves_casa="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,FECHA,ESTADO,NUM_JOR,ID_EVE,GRUPO)
													VALUES (0,0,NULL,0,".($num_jornada).",".$IDEventoLlaves.",".$num_grupo.")";							
							$query=mysql_query($sql_partido_llaves_casa, $conn);
								
							if($a<>$total_fases){	
								$sql_partido_llaves_visita="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,FECHA,ESTADO,NUM_JOR,ID_EVE,GRUPO)
															VALUES (0,0,NULL,0,".($num_jornada+1).",".$IDEventoLlaves.",".$num_grupo.")";					
								$query=mysql_query($sql_partido_llaves_visita, $conn);
							}
						}			
					}
					$num_jornada=$num_jornada+2;//su mar el numero de jornada de dos en dos por el partido ida y vuelta
				}
				
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
			alert('Los campos con asterisco (*) son requeridos');
			history.go(-1);
	</script>";
}
?>