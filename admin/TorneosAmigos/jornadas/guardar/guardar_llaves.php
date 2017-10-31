<?php
include('../../conexiones/conec_cookies.php');
include_once('../../FPHP/funciones.php');
setlocale(LC_TIME, 'Spanish');
	
//comprobar si se ingresaron lkos equipos y provar si son mas de dos
$i=1;
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

	//-----------------------------llaves---------------------------------
	$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_POST['HidTorneo']." and TIPO=2";
	$query = mysql_query($sql, $conn);
	$row=mysql_fetch_assoc($query);
	
	//-----------------------------consulta a grupos---------------------------------
	$sql_grupos = "SELECT ID FROM t_eventos WHERE ID_TORNEO=".$_POST['HidTorneo']." and TIPO=1";
	$query_grupos = mysql_query($sql_grupos, $conn);
	$row_grupos=mysql_fetch_assoc($query_grupos);
	
	//consulta para optener el ultimo grupo
	$cadena_ultimo="SELECT MAX( t_jornadas.NUM_JOR ) as UJOR , max( t_jornadas.grupo ) as UGRU
							FROM t_jornadas
							WHERE t_jornadas.ID_EVE=".$row_grupos['ID'];
	$consulta_ultimo = mysql_query($cadena_ultimo, $conn);
	$resultado_ultimo=mysql_fetch_assoc($consulta_ultimo);
	
	$total_fases=$_POST['txt_cant_fase'];
	$num_jornada=$resultado_ultimo['UJOR'];
	$num_grupo=$resultado_ultimo['UGRU'];
	
	for($a=1;$a<=$total_fases;$a++){
		for($i=1;$i<=$_POST['txtfase'.$a];$i++){
			$num_grupo=$num_grupo+1;
		
			if($a==1){			
				$nombre_grupo=$_POST["h_partido_".$i."_1"];
			
				list($id_equipo_casa,$id_equipo_visita)=explode(',',$nombre_grupo);
				//---------------------------se establece la relacion entre los equipo casa y el evento-----
				$sql_equi_casa="INSERT INTO t_even_equip (NUM_GRUP,ID_EQUI,ID_EVEN)
								VALUES (0,".$id_equipo_casa.",".$row['ID'].")";
				$query=mysql_query($sql_equi_casa, $conn);

				//---------------------------se establece la relacion entre los equipo visita y el evento-----
				$sql_equi_visit="INSERT INTO t_even_equip(NUM_GRUP,ID_EQUI,ID_EVEN)
								 VALUES (0,".$id_equipo_visita.",".$row['ID'].")";
				$query=mysql_query($sql_equi_visit, $conn);
				//---------------------------se guardar los partidos-----
				$sql_partido_llaves_casa="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,ESTADO,NUM_JOR,ID_EVE,GRUPO) 
				 						VALUES (".$id_equipo_casa.",
												".$id_equipo_visita.",
												2,
												".($num_jornada+1).",
												".$row['ID'].",
												".$num_grupo.")";
				$query=mysql_query($sql_partido_llaves_casa, $conn);
				
				if($a<>$total_fases){
					//---------------------------se guardar los partidos-----
					$sql_partido_llaves_visita="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,ESTADO,NUM_JOR,ID_EVE,GRUPO)
											 VALUES (".$id_equipo_visita.",
													".$id_equipo_casa.",
													0,
													".($num_jornada+2).",
													".$row['ID'].",
													".$num_grupo.")";
					$query=mysql_query($sql_partido_llaves_visita, $conn);
				}
			}
			else{
				$sql_partido_llaves_casa="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,ESTADO,NUM_JOR,ID_EVE,GRUPO)
				 						VALUES (0,
												0,
												0,
												".($num_jornada+1).",
												".$row['ID'].",
												".$num_grupo.")";
				$query=mysql_query($sql_partido_llaves_casa, $conn);
					
				if($a<>$total_fases){
					$sql_partido_llaves_visita="INSERT INTO t_jornadas (ID_EQUI_CAS,ID_EQUI_VIS,ESTADO,NUM_JOR,ID_EVE,GRUPO) 
											VALUES (0,
													0,
													0,
													".($num_jornada+2).",
													".$row['ID'].",
													".$num_grupo.")";
					$query=mysql_query($sql_partido_llaves_visita, $conn);
				}
			}				
		}
		$num_jornada=$num_jornada+2;
	}
	echo "<script type=\"text/javascript\">
   		alert('Torneo creado correctamente');
		document.location.href='../jor_llaves.php?ID=".$_POST['HidTorneo']."&NOMB=".$_POST['HidNomb']."';
	</script>";
}
else{
	echo "<script type=\"text/javascript\">
			alert('Los campos con asterisco (*) son requeridos');
			history.go(-1);
	</script>";
}
?>