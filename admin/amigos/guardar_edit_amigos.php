<?php
include('../conexiones/conec_cookies.php');

setlocale(LC_TIME, 'Spanish');

function buscar_punto($cadena){
 if (strrpos($cadena,"."))     
     return true;     
 else    
     return false;     
}

function cambiaf_a_mysql($fecha){
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];

	return $lafecha;
} 

function comprobar_fecha($fecha){
	$resultado=0;
	$dia=0; $mes=0;$anio=0;
	list($dia, $mes,$anio ) = explode("/",$fecha);
	
	if(is_numeric($dia)){
		if(is_numeric($mes)){
			if(is_numeric($anio)){
				$resultado=checkdate($mes,$dia,$anio);
			}
			else{
				$resultado=0;
			}
		}
		else{
			$resultado=0;
		}
	}
	else{
		$resultado=0;
	}
	
	return $resultado;
}


list($id_torneo, $cant_equi) = explode("/",$_POST['info']);

$flag=0;
for($i=1;$i<=$cant_equi;$i++){
	if(!(isset($_POST['nom_equi'.$i]))
		||!(is_numeric($_POST['pj'.$i]))
		||!(is_numeric($_POST['pg'.$i]))
		||!(is_numeric($_POST['pe'.$i]))
		||!(is_numeric($_POST['pp'.$i]))
		||!(is_numeric($_POST['ga'.$i]))
		||!(is_numeric($_POST['gr'.$i]))
		||!(is_numeric($_POST['pts'.$i]))){
	 	$flag=1;
	}
	
	if((buscar_punto($_POST['pj'.$i]))
		||(buscar_punto($_POST['pg'.$i]))
		||(buscar_punto($_POST['pe'.$i]))
		||(buscar_punto($_POST['pp'.$i]))
		||(buscar_punto($_POST['ga'.$i]))
		||(buscar_punto($_POST['gr'.$i]))
		||(buscar_punto($_POST['pts'.$i]))){
	 	 $flag=1;
	}
}

$num_jor=0;
$residuo=$cant_equi%2;
if($residuo==1){
	$num_jor=1;
}
$num_jor=($num_jor+$cant_equi)/2;
for($i=1;$i<=$num_jor;$i++){
	if(!(isset($_POST['equipo_casa'.$i]))
		||!(is_numeric($_POST['marc_casa'.$i]))
		||!(isset($_POST['equipo_vis'.$i]))
		||!(is_numeric($_POST['marc_vis'.$i]))
		||!(isset($_POST['fecha'.$i]))
		||(comprobar_fecha($_POST['fecha'.$i])==0)){
			
		echo $flag=1;
	}
	if((buscar_punto($_POST['marc_casa'.$i]))
		||(buscar_punto($_POST['marc_vis'.$i]))){
		 $flag=1;
	}
}


if($flag==0){
	
	//editar el troneo creado
	if($_POST['estado']==""){
		$_POST['estado']=0;
	}
	
	$sql_torneo="UPDATE t_tor_amigo SET NOMBRE='".$_POST["nom_torneo"]."', ESTADO=".$_POST['estado']."
				WHERE ID=".$id_torneo;
	$query_torneo=mysql_query($sql_torneo, $conn);
	
	for($i=1;$i<=$cant_equi;$i++){
		
		//editar estadisticas
		$sql_est="UPDATE t_est_amigos SET	EQUIPO='".$_POST['nom_equi'.$i]."',PJ=".$_POST['pj'.$i].",
											PG=".$_POST['pg'.$i].",PE=".$_POST['pe'.$i].",
											PP=".$_POST['pp'.$i].",GA=".$_POST['ga'.$i].",
											GR=".$_POST['gr'.$i].",PTS=".$_POST['pts'.$i].
											" WHERE ID=".$_POST['id_est'.$i];
		$query_est=mysql_query($sql_est, $conn);
	}
	
	$residuo=$cant_equi%2;
	$num_jor=0;
	if($residuo==1){
		$num_jor=1;
	}
	$num_jor=($num_jor+$cant_equi)/2;
	
	for($i=1;$i<=$num_jor;$i++){
		
		//editar jornadas
		$sql_jor="UPDATE t_jor_amigos SET EQUI_CASA='".$_POST['equipo_casa'.$i]."',
											MARC_CASA=".$_POST['marc_casa'.$i].",EQUI_VIS='".$_POST['equipo_vis'.$i]."',
											MARC_VIS=".$_POST['marc_vis'.$i].",FECHA='".cambiaf_a_mysql($_POST['fecha'.$i])."'
											 WHERE ID=".$_POST['id_jor'.$i];
		$query_jor=mysql_query($sql_jor, $conn);
	}
	
	echo "
	<script type=\"text/javascript\">
			alert('Torneo amigo editado correctamente');
			document.location.href='torneos_amigos.php';
	</script>";
}
else{
	echo "<script type=\"text/javascript\">
			alert('Error por datos insuficiente o los datos en las campos para fechas tienen problemas');
			history.go(-1);
		</script>";
}
?>