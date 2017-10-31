<?php
include('../../conexiones/conec_cookies.php');

// obtener las jornada de ida y vuelta de la que se quiere retroceder
list($primera_jor,$segundo_jor)=explode("/",$_POST['radio_llaves']);
//obtener la primera y ultima jornada
list($min_jor,$max_jor)=explode("/",$_POST['min_max']);

 //recorre las jornadas apartir de la primera de face de llaves y hasta la ultima
for($i=$primera_jor;$i<=$max_jor;$i+=2){
	
	//consultar las jornadas de ida
	$sql_jornada = "SELECT * FROM t_jornadas
					WHERE ID_EVE=".$_POST['id_eve']." AND NUM_JOR=".$i;
	$consulta_jornada = mysql_query($sql_jornada, $conn);
	$flag_ida=mysql_num_rows($consulta_jornada);
	
	//consultar las jornadas de vuelta
	$sql_jornada2 = "SELECT * FROM t_jornadas
					WHERE ID_EVE=".$_POST['id_eve']." AND NUM_JOR=".($i+1);
	$consulta_jornada2 = mysql_query($sql_jornada2, $conn);
	$flag_vuelta=mysql_num_rows($consulta_jornada2);// cantidad de jornada de vuelta
	
	//recorer las jornadas ida
	while($row_jornada=mysql_fetch_assoc($consulta_jornada)){
		//si el estado es mayor o igual a jugado y anterior
		if(($row_jornada['ESTADO']>=3)){
			
			//si no se ha ingresado marcadores casa	
			if($row_jornada['MARCADOR_CASA']==''){
				$row_jornada['MARCADOR_CASA']=0;
			}
			
			//si no se ha ingresado marcadores visita
			if($row_jornada['MARCADOR_VISITA']==''){
				$row_jornada['MARCADOR_VISITA']=0;
			}
			
			//CALCULAR EL MARCADOR  ida
			$equi_1_pg_ida=0;
			$equi_1_pe_ida=0;
			$equi_1_pp_ida=0;
			$equi_1_pts_ida=0;
			$equi_2_pg_ida=0;
			$equi_2_pe_ida=0;
			$equi_2_pp_ida=0;
			$equi_2_pts_ida=0;
			
			//descubrir ganador nuevo
			$resultado_ida=($row_jornada['MARCADOR_CASA'])-($row_jornada['MARCADOR_VISITA']);
			if($resultado_ida>0){//si casa gano
				$equi_1_pg_ida=1;
				$equi_2_pp_ida=1;
				$equi_1_pp_ida=0;
				$equi_2_pg_ida=0;
				$equi_1_pe_ida=0;
				$equi_2_pe_ida=0;
				$equi_1_pts_ida=3;
				$equi_2_pts_ida=0;
			}
			else if($resultado_ida==0){//si empataron
				$equi_1_pg_ida=0;
				$equi_2_pp_ida=0;
				$equi_1_pe_ida=1;
				$equi_2_pe_ida=1;
				$equi_1_pp_ida=0;
				$equi_2_pg_ida=0;
				$equi_1_pts_ida=1;
				$equi_2_pts_ida=1;
			}
			else{//si visita gano
				$equi_1_pp_ida=1;
				$equi_2_pg_ida=1;
				$equi_1_pg_ida=0;
				$equi_2_pp_ida=0;
				$equi_1_pe_ida=0;
				$equi_2_pe_ida=0;
				$equi_1_pts_ida=0;
				$equi_2_pts_ida=3;
			}
		
			//modificar estadisticas equi casa
			$sql_est_equi_ida = "UPDATE t_est_equi SET
								PAR_JUG_ACU=PAR_JUG_ACU-1,
								PAR_GAN_ACU=PAR_GAN_ACU-".$equi_1_pg_ida.",
								PAR_EMP_ACU=PAR_EMP_ACU-".$equi_1_pe_ida.",
								PAR_PER_ACU=PAR_PER_ACU-".$equi_1_pp_ida.",
								GOL_ANO_ACU=GOL_ANO_ACU-".$row_jornada['MARCADOR_CASA'].",
								GOL_RES_ACU=GOL_RES_ACU-".$row_jornada['MARCADOR_VISITA'].",
								PTS_ACU=PTS_ACU-".$equi_1_pts_ida.
							"  WHERE ID_TORNEO=".$_POST['id_tor']." AND ID_EQUI=".$row_jornada['ID_EQUI_CAS'];
			$consulta_est_equi_ida = mysql_query($sql_est_equi_ida, $conn);
			
			//modificar estadisticas equi visita
			$sql_est_equi2_ida = "UPDATE t_est_equi SET 
							PAR_JUG_ACU=PAR_JUG_ACU-1,
							PAR_GAN_ACU=PAR_GAN_ACU-".$equi_2_pg_ida.",
							PAR_EMP_ACU=PAR_EMP_ACU-".$equi_2_pe_ida.",
							PAR_PER_ACU=PAR_PER_ACU-".$equi_2_pp_ida.",
							GOL_ANO_ACU=GOL_ANO_ACU-".$row_jornada['MARCADOR_VISITA'].",
							GOL_RES_ACU=GOL_RES_ACU-".$row_jornada['MARCADOR_CASA'].",
							PTS_ACU=PTS_ACU-".$equi_2_pts_ida.
						" WHERE ID_TORNEO=".$_POST['id_tor']." AND ID_EQUI=".$row_jornada['ID_EQUI_VIS'];
			$consulta_est_equi2_ida = mysql_query($sql_est_equi2_ida, $conn);
		
		}
	}
	
	//verificar si todavia es de ida y vuelta, en caso de no haver no realizar
	if($flag_vuelta>0){
		//recorer las jornadas vuleta
		while($row_jornada2=mysql_fetch_assoc($consulta_jornada2)){
			//si el estado es mayor o igual a jugado y anterior
			if($row_jornada2['ESTADO']>=3){	
				
				//si no se ha ingresado marcadores casa	
				if($row_jornada2['MARCADOR_CASA']==''){
					$row_jornada2['MARCADOR_CASA']=0;
				}
				
				//si no se ha ingresado marcadores casa	
				if($row_jornada2['MARCADOR_VISITA']==''){
					$row_jornada2['MARCADOR_VISITA']=0;
				}
		
				//CALCULAR EL MARCADOR  VUELTA
				$equi_1_pg_vuel=0;
				$equi_1_pe_vuel=0;
				$equi_1_pp_vuel=0;
				$equi_1_pts_vuel=0;
				$equi_2_pg_vuel=0;
				$equi_2_pe_vuel=0;
				$equi_2_pp_vuel=0;
				$equi_2_pts_vuel=0;
				
				//descubrir ganador nuevo
				$resultado_vuel=($row_jornada2['MARCADOR_CASA'])-($row_jornada2['MARCADOR_VISITA']);
				if($resultado_vuel>0){//si casa gano
					$equi_1_pg_vuel=1;
					$equi_2_pp_vuel=1;
					$equi_1_pp_vuel=0;
					$equi_2_pg_vuel=0;
					$equi_1_pe_vuel=0;
					$equi_2_pe_vuel=0;
					$equi_1_pts_vuel=3;
					$equi_2_pts_vuel=0;
				}
				else if($resultado_vuel==0){//si empataron
					$equi_1_pg_vuel=0;
					$equi_2_pp_vuel=0;
					$equi_1_pe_vuel=1;
					$equi_2_pe_vuel=1;
					$equi_1_pp_vuel=0;
					$equi_2_pg_vuel=0;
					$equi_1_pts_vuel=1;
					$equi_2_pts_vuel=1;
				}
				else{//si visita gano
					$equi_1_pp_vuel=1;
					$equi_2_pg_vuel=1;
					$equi_1_pg_vuel=0;
					$equi_2_pp_vuel=0;
					$equi_1_pe_vuel=0;
					$equi_2_pe_vuel=0;
					$equi_1_pts_vuel=0;
					$equi_2_pts_vuel=3;
				}
		
				//modificar estadisticas equipo casa
				$sql_est_equi_vuel = "UPDATE t_est_equi SET
									PAR_JUG_ACU=PAR_JUG_ACU-1,
									PAR_GAN_ACU=PAR_GAN_ACU-".$equi_1_pg_vuel.",
									PAR_EMP_ACU=PAR_EMP_ACU-".$equi_1_pe_vuel.",
									PAR_PER_ACU=PAR_PER_ACU-".$equi_1_pp_vuel.",
									GOL_ANO_ACU=GOL_ANO_ACU-".$row_jornada2['MARCADOR_CASA'].",
									GOL_RES_ACU=GOL_RES_ACU-".$row_jornada2['MARCADOR_VISITA'].",
									PTS_ACU=PTS_ACU-".$equi_1_pts_vuel.
								"  WHERE ID_TORNEO=".$_POST['id_tor']." AND ID_EQUI=".$row_jornada2['ID_EQUI_CAS'];
				$consulta_est_equi_vuel = mysql_query($sql_est_equi_vuel, $conn);
				
				//modificar estadisticas equipo visita
				$sql_est_equi2_vuel = "UPDATE t_est_equi SET 
									PAR_JUG_ACU=PAR_JUG_ACU-1,
									PAR_GAN_ACU=PAR_GAN_ACU-".$equi_2_pg_vuel.",
									PAR_EMP_ACU=PAR_EMP_ACU-".$equi_2_pe_vuel.",
									PAR_PER_ACU=PAR_PER_ACU-".$equi_2_pp_vuel.",
									GOL_ANO_ACU=GOL_ANO_ACU-".$row_jornada2['MARCADOR_VISITA'].",
									GOL_RES_ACU=GOL_RES_ACU-".$row_jornada2['MARCADOR_CASA'].",
									PTS_ACU=PTS_ACU-".$equi_2_pts_vuel.
								" WHERE ID_TORNEO=".$_POST['id_tor']." AND ID_EQUI=".$row_jornada2['ID_EQUI_VIS'];
				$consulta_est_equi2_vuel = mysql_query($sql_est_equi2_vuel, $conn);
			}
		}	
	}
	
	// si es la primera vuelta actualice estado a siguiente
	if($primera_jor==$i){
		$estado=" ESTADO=2, ";
	}
	else{//si no pongalo como no jugado
		$estado="ESTADO=0,";
	}
	
	//actualizar jornadas a marcadores nullos y sin equipos
	$sql_jor_limpiar = "UPDATE t_jornadas SET
					ID_EQUI_CAS=0,
					ID_EQUI_VIS=0,
					".$estado."
					MARCADOR_CASA=NULL,
					MARCADOR_VISITA=NULL
				WHERE ID_EVE=".$_POST['id_eve']." AND NUM_JOR=".$i;
	$consulta_jor_limpiar = mysql_query($sql_jor_limpiar, $conn);
	
	//actualializar jornadass a marcadores nullos y sin equipos
	$sql_jor2_limpiar = "UPDATE t_jornadas SET
						ID_EQUI_CAS=0,
						ID_EQUI_VIS=0,
						ESTADO=0,
						MARCADOR_CASA=NULL,
						MARCADOR_VISITA=NULL
					WHERE ID_EVE=".$_POST['id_eve']." AND NUM_JOR=".($i+1);
	$consulta_jor2_limpiar = mysql_query($sql_jor2_limpiar, $conn);
}
//fin for

echo "<script type=\"text/javascript\">
   		alert('Las jornadas de llaves han sido reseteadas.');
		document.location.href='../../index.php';
	</script>";
?>