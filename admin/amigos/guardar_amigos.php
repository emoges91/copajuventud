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


list($cant_equi, $estado) = explode("/",$_POST['info']);

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
			
		 $flag=1;
	}
	if((buscar_punto($_POST['marc_casa'.$i]))
		||(buscar_punto($_POST['marc_vis'.$i]))){
		 $flag=1;
	}
}


if($flag==0){
	
	//guardar el troneo creado
	$sql_torneo="INSERT INTO t_tor_amigo VALUES(NULL,'".$_POST["nom_torneo"]."',".$cant_equi.",".$estado.")";
	$query_torneo=mysql_query($sql_torneo, $conn);
	
	//consultar el torneo recien creado
	$sql_torneo_cons="SELECT * FROM t_tor_amigo
					WHERE NOMBRE='".$_POST["nom_torneo"]."' AND CANT=".$cant_equi." AND ESTADO=".$estado;				
	$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);
	$fila_torneo_con=mysql_fetch_assoc($query_torneo_cons);
	
	for($i=1;$i<=$cant_equi;$i++){
		$sql_est="INSERT INTO t_est_amigos VALUES(NULL,".$fila_torneo_con["ID"].",
											'".$_POST['nom_equi'.$i]."',".$_POST['pj'.$i].",
											".$_POST['pg'.$i].",".$_POST['pe'.$i].",
											".$_POST['pp'.$i].",".$_POST['ga'.$i].",
											".$_POST['gr'.$i].",".$_POST['pts'.$i].");";
		$query_est=mysql_query($sql_est, $conn);
	}
	
	$residuo=$cant_equi%2;
	$num_jor=0;
	if($residuo==1){
		$num_jor=1;
	}
	$num_jor=($num_jor+$cant_equi)/2;
	
	for($i=1;$i<=$num_jor;$i++){
		$sql_jor="INSERT INTO t_jor_amigos VALUES(NULL,'".$_POST['equipo_casa'.$i]."',
											".$_POST['marc_casa'.$i].",'".$_POST['equipo_vis'.$i]."',
											".$_POST['marc_vis'.$i].",'".cambiaf_a_mysql($_POST['fecha'.$i])."',
											".$fila_torneo_con["ID"].");";
		$query_jor=mysql_query($sql_jor, $conn);
	}
	
	echo "
	<script type=\"text/javascript\">
			alert('Torneos amigos registradas correctamente');
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