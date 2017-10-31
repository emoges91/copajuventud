<?php
include('../../conexiones/conec_cookies.php');
include_once('../../FPHP/funciones.php');

$flag=0;
//verificar que los marcadores sean nuemros enteros positivos  			
if((buscar_punto($_POST['TXT_marcadorCasa_nuevo'])==true) || (buscar_punto($_POST['TXT_marcadorVisita_nuevo'])==true)
	||(is_numeric($_POST['TXT_marcadorCasa_nuevo'])==FALSE) || (is_numeric($_POST['TXT_marcadorVisita_nuevo'])==FALSE)
	||($_POST['TXT_marcadorCasa_nuevo']<0) || ($_POST['TXT_marcadorVisita_nuevo']<0)){				
	$flag=1;
}
//comprobar que los marcadores no vengan vacios
if((trim($_POST['TXT_marcadorCasa_nuevo'])=="")&&(trim($_POST['TXT_marcadorVisita_nuevo'])=="")){
	$flag=0;
}


//condicion para guardar****************************************************************************************************************
if(($flag==0)){		
	$marcador_null=0;
	//si el marcador casa viene vacios poner en null				
	if(trim($_POST['TXT_marcadorCasa_nuevo'])==''){
		$_POST['TXT_marcadorCasa_nuevo']='NULL';
		$marcador_null=1;
	}
	//si el marcador visita viene vacios poner en null	
	if(trim($_POST['TXT_marcadorVisita_nuevo'])==''){
		$_POST['TXT_marcadorVisita_nuevo']='NULL';
		$marcador_null=1;
	}
	
	//numero de jornada anterior
	$anterior_Njugado=0;	
	//asignar 0 si el marcador casa viejo es nulo 
	if(trim($_POST['hdn_marcadorCasa_viejo'])=='-'){
		$_POST['hdn_marcadorCasa_viejo']=0;
		$anterior_Njugado=1;
	}
	//asignar 0 si el marcador visita viejo es nulo 
	if(trim($_POST['hdn_marcadorVisita_viejo'])=='-'){
		$_POST['hdn_marcadorVisita_viejo']=0;
		$anterior_Njugado=1;
	}
	
	//si el estado es anterior o jugado
	if($_POST['hdn_estado']>=3){
		//actualizar jornada con nuevos marcadores
		$str_consulta="UPDATE t_jornadas SET 
			MARCADOR_CASA=".$_POST['TXT_marcadorCasa_nuevo'].",
			MARCADOR_VISITA=".$_POST['TXT_marcadorVisita_nuevo']."
		WHERE ID=".$_POST['hdn_id'];
		
		$equi_1_pg_v=0;
		$equi_1_pe_v=0;
		$equi_1_pp_v=0;
		$equi_1_pts_v=0;
		$equi_2_pg_v=0;
		$equi_2_pe_v=0;
		$equi_2_pp_v=0;
		$equi_2_pts_v=0;
			
		//validar que el partido en realidad se jugo para quitar el viejo resultado de las estadisticas
		if($anterior_Njugado==0){ 
			//descubrir ganador viejo
			$resultado_viejo=($_POST['hdn_marcadorCasa_viejo'])-($_POST['hdn_marcadorVisita_viejo']);
			if($resultado_viejo>0){
				$equi_1_pg_v=1;
				$equi_2_pp_v=1;
				$equi_1_pp_v=0;
				$equi_2_pg_v=0;
				$equi_1_pe_v=0;
				$equi_2_pe_v=0;
				$equi_1_pts_v=3;
				$equi_2_pts_v=0;
			}
			else if($resultado_viejo==0){
				$equi_1_pg_v=0;
				$equi_2_pp_v=0;
				$equi_1_pe_v=1;
				$equi_2_pe_v=1;
				$equi_1_pp_v=0;
				$equi_2_pg_v=0;
				$equi_1_pts_v=1;
				$equi_2_pts_v=1;
			}
			else{
				$equi_1_pp_v=1;
				$equi_2_pg_v=1;
				$equi_1_pg_v=0;
				$equi_2_pp_v=0;
				$equi_1_pe_v=0;
				$equi_2_pe_v=0;
				$equi_1_pts_v=0;
				$equi_2_pts_v=3;
			}			
		
			//quitar los datos viejos	
			$str_consulta_equi_1_v="UPDATE t_est_equi SET "; 
			//consulta solo para jornadas de fase de grupos
			if($_POST['hdn_tipo']==1){
				$str_consulta_equi_1_v=$str_consulta_equi_1_v."PAR_JUG=PAR_JUG-1,
					PAR_GAN=PAR_GAN-".$equi_1_pg_v.",
					PAR_EMP=PAR_EMP-".$equi_1_pe_v.",
					PAR_PER=PAR_PER-".$equi_1_pp_v.",
					GOL_ANO=GOL_ANO-".$_POST['hdn_marcadorCasa_viejo'].",
					GOL_RES=GOL_RES-".$_POST['hdn_marcadorVisita_viejo'].",
					PTS=PTS-".$equi_1_pts_v.",";
			}
			
			//quitar a los datos de tabla general
			$str_consulta_equi_1_v=$str_consulta_equi_1_v."PAR_JUG_ACU=PAR_JUG_ACU-1,
				PAR_GAN_ACU=PAR_GAN_ACU-".$equi_1_pg_v.",
				PAR_EMP_ACU=PAR_EMP_ACU-".$equi_1_pe_v.",
				PAR_PER_ACU=PAR_PER_ACU-".$equi_1_pp_v.",
				GOL_ANO_ACU=GOL_ANO_ACU-".$_POST['hdn_marcadorCasa_viejo'].",
				GOL_RES_ACU=GOL_RES_ACU-".$_POST['hdn_marcadorVisita_viejo'].",
				PTS_ACU=PTS_ACU-".$equi_1_pts_v."
				WHERE ID_EQUI=".$_POST['hdn_id_casa'];
	
			$str_consulta_equi_2_v="UPDATE t_est_equi SET ";
			//consulta solo para jornadas de fase de grupos
			if( ($_POST['hdn_tipo']==1) ){ 
				$str_consulta_equi_2_v=$str_consulta_equi_2_v."PAR_JUG=PAR_JUG-1,
					PAR_GAN=PAR_GAN-".$equi_2_pg_v.",
					PAR_EMP=PAR_EMP-".$equi_2_pe_v.",
					PAR_PER=PAR_PER-".$equi_2_pp_v.",
					GOL_ANO=GOL_ANO-".$_POST['hdn_marcadorVisita_viejo'].",
					GOL_RES=GOL_RES-".$_POST['hdn_marcadorCasa_viejo'].",
					PTS=PTS-".$equi_2_pts_v.",";
			}
			//quitar a los datos de tabla general
			$str_consulta_equi_2_v=$str_consulta_equi_2_v."PAR_JUG_ACU=PAR_JUG_ACU-1,
				PAR_GAN_ACU=PAR_GAN_ACU-".$equi_2_pg_v.",
				PAR_EMP_ACU=PAR_EMP_ACU-".$equi_2_pe_v.",
				PAR_PER_ACU=PAR_PER_ACU-".$equi_2_pp_v.",
				GOL_ANO_ACU=GOL_ANO_ACU-".$_POST['hdn_marcadorVisita_viejo'].",
				GOL_RES_ACU=GOL_RES_ACU-".$_POST['hdn_marcadorCasa_viejo'].",
				PTS_ACU=PTS_ACU-".$equi_2_pts_v."
			WHERE ID_EQUI=".$_POST['hdn_id_vis'];
			
			// ejecutar las consultas para disminuir las estadistican en caso de que ya se habia jugado el partido
			$consulta_equi_1_v= mysql_query($str_consulta_equi_1_v, $conn)or die(mysql_error());
			$consulta_equi_1_v= mysql_query($str_consulta_equi_2_v, $conn)or die(mysql_error());
		}
		
		if($marcador_null==0){
			$equi_1_pg_n=0;
			$equi_1_pe_n=0;
			$equi_1_pp_n=0;
			$equi_1_pts_n=0;
			$equi_2_pg_n=0;
			$equi_2_pe_n=0;
			$equi_2_pp_n=0;
			$equi_2_pts_n=0;
			
			//descubrir ganador nuevo
			$resultado_nuevo=($_POST['TXT_marcadorCasa_nuevo'])-($_POST['TXT_marcadorVisita_nuevo']);
			if($resultado_nuevo>0){
				$equi_1_pg_n=1;
				$equi_2_pp_n=1;
				$equi_1_pp_n=0;
				$equi_2_pg_n=0;
				$equi_1_pe_n=0;
				$equi_2_pe_n=0;
				$equi_1_pts_n=3;
				$equi_2_pts_n=0;
			}
			else if($resultado_nuevo==0){
				$equi_1_pg_n=0;
				$equi_2_pp_n=0;
				$equi_1_pe_n=1;
				$equi_2_pe_n=1;
				$equi_1_pp_n=0;
				$equi_2_pg_n=0;
				$equi_1_pts_n=1;
				$equi_2_pts_n=1;
			}
			else{
				$equi_1_pp_n=1;
				$equi_2_pg_n=1;
				$equi_1_pg_n=0;
				$equi_2_pp_n=0;
				$equi_1_pe_n=0;
				$equi_2_pe_n=0;
				$equi_1_pts_n=0;
				$equi_2_pts_n=3;
			}
			
			//guardar los datos nuevos
			$str_consulta_equi_1_n="UPDATE t_est_equi SET ";
			//consulta solo para jornadas de fase de grupos
			if( ($_POST['hdn_tipo']==1) ){  
				$str_consulta_equi_1_n=$str_consulta_equi_1_n."PAR_JUG=PAR_JUG+1,
					PAR_GAN=PAR_GAN+".$equi_1_pg_n.",
					PAR_EMP=PAR_EMP+".$equi_1_pe_n.",
					PAR_PER=PAR_PER+".$equi_1_pp_n.",
					GOL_ANO=GOL_ANO+".$_POST['TXT_marcadorCasa_nuevo'].",
					GOL_RES=GOL_RES+".$_POST['TXT_marcadorVisita_nuevo'].",
					PTS=PTS+".$equi_1_pts_n.",";
			}
			$str_consulta_equi_1_n=$str_consulta_equi_1_n."PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+".$equi_1_pg_n.",
				PAR_EMP_ACU=PAR_EMP_ACU+".$equi_1_pe_n.",
				PAR_PER_ACU=PAR_PER_ACU+".$equi_1_pp_n.",
				GOL_ANO_ACU=GOL_ANO_ACU+".$_POST['TXT_marcadorCasa_nuevo'].",
				GOL_RES_ACU=GOL_RES_ACU+".$_POST['TXT_marcadorVisita_nuevo'].",
				PTS_ACU=PTS_ACU+".$equi_1_pts_n."
			WHERE ID_EQUI=".$_POST['hdn_id_casa'];;
	
			$str_consulta_equi_2_n="UPDATE t_est_equi SET ";
			//consulta solo para jornadas de fase de grupos
			if( ($_POST['hdn_tipo']==1) ){   
				$str_consulta_equi_2_n=$str_consulta_equi_2_n."PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+".$equi_2_pg_n.",
				PAR_EMP=PAR_EMP+".$equi_2_pe_n.",
				PAR_PER=PAR_PER+".$equi_2_pp_n.",
				GOL_ANO=GOL_ANO+".$_POST['TXT_marcadorVisita_nuevo'].",
				GOL_RES=GOL_RES+".$_POST['TXT_marcadorCasa_nuevo'].",
				PTS=PTS+".$equi_2_pts_n.",";
			}
			$str_consulta_equi_2_n=$str_consulta_equi_2_n."PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+".$equi_2_pg_n.",
				PAR_EMP_ACU=PAR_EMP_ACU+".$equi_2_pe_n.",
				PAR_PER_ACU=PAR_PER_ACU+".$equi_2_pp_n.",
				GOL_ANO_ACU=GOL_ANO_ACU+".$_POST['TXT_marcadorVisita_nuevo'].",
				GOL_RES_ACU=GOL_RES_ACU+".$_POST['TXT_marcadorCasa_nuevo'].",
				PTS_ACU=PTS_ACU+".$equi_2_pts_n."
			WHERE ID_EQUI=".$_POST['hdn_id_vis'];;
			
			// ejecutar las consultas para aumentar las estadistican 
			$consulta_equi_1_n = mysql_query($str_consulta_equi_1_n, $conn)or die(mysql_error());
			$consulta_equi_1_n= mysql_query($str_consulta_equi_2_n, $conn)or die(mysql_error());
		}
	}
	
	//actualizar estado a anterrior con el string de arriba
	$consulta = mysql_query($str_consulta, $conn)or die(mysql_error());
	
	if(($_POST['hdn_tipo']==1)){
		echo "
		<script type=\"text/javascript\">
			alert('Jornadas registradas correctamente');
			document.location.href='../jor_grupos.php?ID=".$_POST['hdn_id_troneo']."&NOM=".$_POST['hdn_nomb_troneo']."';
		</script>";
	}
	else {
		echo "
		<script type=\"text/javascript\">
			alert('Jornadas registradas correctamente');
			document.location.href='../jor_llaves.php?ID=".$_POST['hdn_id_troneo']."&NOM=".$_POST['hdn_nomb_troneo']."';
		</script>";
	}
}
else{
	echo "
	<script type=\"text/javascript\">
		alert('Se debe digitar numeros enteros positivos en los marcadores.');
		history.go(-1);
	</script>";
}
?>
