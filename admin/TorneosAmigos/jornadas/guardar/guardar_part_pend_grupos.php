<?php
include('../../conexiones/conec_cookies.php');
include_once('../../FPHP/funciones.php');

$flag=0;
$flag_chekeados=0;
//recorrer los partidos para comprobar
for($i=1;$i<=$_POST['total_partidos'];$i++){
	
	$id_partido=$_POST['hdn_idPartido'.$i];
		
	//consulta para obtener los id de los equipos
	$str_consulta_equipos="SELECT * FROM t_jornadas 
							WHERE ID=".$id_partido;
	$consulta_equipos = mysql_query($str_consulta_equipos, $conn)or die(mysql_error());
	$fila=mysql_fetch_assoc($consulta_equipos);
	
	//verificar si el id de equipos casa o visita es =0
	$var_flag=0;
	if(($fila['ID_EQUI_CAS']==0)||($fila['ID_EQUI_VIS']==0)){
		$var_flag=1;
	}
	
	//verificar si el check esta checkiado
	if (($_POST['CHK_partidos'.$i]=='on')&&($var_flag==0)){
		$marcador_casa=$_POST['TXT_marcadorCasa'.$i];
		$marcador_visita=$_POST['TXT_marcadorVisita'.$i];
		
		$flag_chekeados=1;//verificar q este minimo uno chekeado
		
		//verificar i los marcadores son numeros enteros positivos		
		if((buscar_punto($marcador_casa)==true)||(buscar_punto($marcador_visita)==true)
		||(is_numeric($marcador_casa)==FALSE)||(is_numeric($marcador_visita)==FALSE)
		|| ($marcador_casa<0)||($marcador_visita<0)){				
			echo $flag=1;
		}
	}	
}

//if para verificar veracidad de datos
if(($flag==0)&&($flag_chekeados==1)){	
	//recorrer los partidos
	for($i=1;$i<=$_POST['total_partidos'];$i++){
		$check_partidos=$_POST['CHK_partidos'.$i];
		$marcadores_casa=$_POST['TXT_marcadorCasa'.$i];
		$maradores_visita=$_POST['TXT_marcadorVisita'.$i];
		$id_partido=$_POST['hdn_idPartido'.$i];
	
		//-----------si esta chekeado
		if ($check_partidos=='on'){
			//asignar null a los marcadore q no tienen nada	
			if(trim($marcadores_casa)==''){
				$marcadores_casa='NULL';
			}
			if(trim($maradores_visita)==''){
				$maradores_visita='NULL';
			}
		
			//actualizar el partido/jornada a estado anterrior
			$str_consulta="UPDATE t_jornadas SET 
				MARCADOR_CASA=".$marcadores_casa.",
				MARCADOR_VISITA=".$maradores_visita.",
				ESTADO=4
			WHERE ID=".$id_partido;
				
			//consulta para obtener los id de los equipos
			$str_consulta_equipos="SELECT * FROM t_jornadas
			WHERE ID=".$id_partido;
			$consulta_equipos = mysql_query($str_consulta_equipos, $conn)or die(mysql_error());
			$fila=mysql_fetch_assoc($consulta_equipos);
		
			$equi_1_pg=0;
			$equi_1_pe=0;
			$equi_1_pp=0;
			$equi_1_pts=0;
			$equi_2_pg=0;
			$equi_2_pe=0;
			$equi_2_pp=0;
			$equi_2_pts=0;
		
			$resultado=($_POST[$marcadores_casa])-($_POST[$maradores_visita]);
			if($resultado>0){
				$equi_1_pg=1;
				$equi_2_pp=1;
				$equi_1_pp=0;
				$equi_2_pg=0;
				$equi_1_pe=0;
				$equi_2_pe=0;
				$equi_1_pts=3;
				$equi_2_pts=0;
			}
			else if($resultado==0){
				$equi_1_pg=0;
				$equi_2_pp=0;
				$equi_1_pe=1;
				$equi_2_pe=1;
				$equi_1_pp=0;
				$equi_2_pg=0;
				$equi_1_pts=1;
				$equi_2_pts=1;
			}
			else{
				$equi_1_pp=1;
				$equi_2_pg=1;
				$equi_1_pg=0;
				$equi_2_pp=0;
				$equi_1_pe=0;
				$equi_2_pe=0;
				$equi_1_pts=0;
				$equi_2_pts=3;
			}

			if(($fila['ID_EQUI_CAS']!='0')&&($fila['ID_EQUI_VIS']!='0'))	{	
				$str_consulta_equi_1="UPDATE t_est_equi SET 
				PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+".$equi_1_pg.",
				PAR_EMP=PAR_EMP+".$equi_1_pe.",
				PAR_PER=PAR_PER+".$equi_1_pp.",
				GOL_ANO=GOL_ANO+".$marcadores_casa.",
				GOL_RES=GOL_RES+".$maradores_visita.",
				PTS=PTS+".$equi_1_pts.",
				PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+".$equi_1_pg.",
				PAR_EMP_ACU=PAR_EMP_ACU+".$equi_1_pe.",
				PAR_PER_ACU=PAR_PER_ACU+".$equi_1_pp.",
				GOL_ANO_ACU=GOL_ANO_ACU+".$marcadores_casa.",
				GOL_RES_ACU=GOL_RES_ACU+".$maradores_visita.",
				PTS_ACU=PTS_ACU+".$equi_1_pts."
				WHERE ID_EQUI=".$fila['ID_EQUI_CAS'];
		
				$str_consulta_equi_2="UPDATE t_est_equi SET 
				PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+".$equi_2_pg.",
				PAR_EMP=PAR_EMP+".$equi_2_pe.",
				PAR_PER=PAR_PER+".$equi_2_pp.",
				GOL_ANO=GOL_ANO+".$maradores_visita.",
				GOL_RES=GOL_RES+".$marcadores_casa.",
				PTS=PTS+".$equi_2_pts.",
				PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+".$equi_2_pg.",
				PAR_EMP_ACU=PAR_EMP_ACU+".$equi_2_pe.",
				PAR_PER_ACU=PAR_PER_ACU+".$equi_2_pp.",
				GOL_ANO_ACU=GOL_ANO_ACU+".$maradores_visita.",
				GOL_RES_ACU=GOL_RES_ACU+".$marcadores_casa.",
				PTS_ACU=PTS_ACU+".$equi_2_pts."
				WHERE ID_EQUI=".$fila['ID_EQUI_VIS'];
				
				$consulta_equi_1 = mysql_query($str_consulta_equi_1, $conn)or die(mysql_error());
				$consulta_equi_1= mysql_query($str_consulta_equi_2, $conn)or die(mysql_error());
			}		
		}
  		else{//si no esta chekeado
			$str_consulta="UPDATE t_jornadas SET 
				ESTADO=1
			WHERE ID=".$id_partido;
		}
		//actualizar estado a anterrior con el string de arriba
		$consulta = mysql_query($str_consulta, $conn)or die(mysql_error());
	}//fin while
	
	list($jornada_actual, $id_evento) = explode("/",$_POST['Hdn_jornadaActual']);

	//preveer si hay partidos pendientes
	$str_consulta_partidos_completos="SELECT * FROM t_jornadas 
			WHERE ESTADO=2 AND ID_EVE=".$id_evento;
	$consulta_partidos_completos = mysql_query($str_consulta_partidos_completos, $conn)or die(mysql_error());
	$cant_partidos_completos = mysql_num_rows($consulta_partidos_completos);

	//actualizar el torneo a la siguiente face
	if($cant_partidos_completos==0){
		$str_consulta="UPDATE t_torneo SET 
			INSTANCIA=INSTANCIA+1
		WHERE ID=".$_POST['id_torneo'];
		$consulta = mysql_query($str_consulta, $conn)or die(mysql_error());
	}

	echo "<script type=\"text/javascript\">
		alert('Jornadas registradas correctamente');
		document.location.href='../jor_grupos.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['nomb_torneo']."';
	</script>";
}
else{
		echo "<script type=\"text/javascript\">
			alert('Los marcadores de los partidos chekeados deben llevar numeros.');
			history.go(-1);
		</script>";
}
?>
