<?php
include('../../conexiones/conec_cookies.php');
$i=1;
$flag=0;
while($i<=$_POST['num_grupos']){
	$nombre_grupo="g_".$i;
	if (!(isset($_POST[$nombre_grupo])and $_POST[$nombre_grupo] != '')){
		$flag=1;
	}
	
	$i++;
}

if ((isset($_POST['jornadas_grupo'])and $_POST['jornadas_grupo'] != '')
	and(isset($_POST['num_grupos'])and $_POST['num_grupos'] != '')
	and($flag==0)and(isset($_POST['id_evento'])and $_POST['id_evento'] != ''))
{

$valores1 = $_POST['jornadas_grupo'];//total de partidos
//recorrer los grupos
for($a=1; $a<=$_POST['num_grupos']; $a++){

	$nombre_grupo = 'g_'.$a;//nombre del hidden de los id de los equipos
	$nombre_grupo2 = 'h_'.$a;//nombre del hidden de los id de los visita
	$valores = $_POST[$nombre_grupo];//array de equipos casa
	$valores2 = $_POST[$nombre_grupo2];//array de equipos visita
	$residuo= count($valores)/$valores1[($a-1)];//cantidad de partidos por jornada
	$jornada=1;
	$conta=0;
	//recorrer las jornadas del grupo
	for ($i=0; $i< count($valores); $i++){
		//si el contador es igual a la cantidad de partidos por jornada
		if($conta==$residuo){
			$jornada++;
			$conta=0;
		}
		
		if($valores[$i]==' '){
			$valores[$i]=0;
		}
		if($valores2[$i]==' '){
			$valores2[$i]=0;
		}
		
		$estado=0;
		if($jornada==1){
			$estado=2;
		}
		
		//agregar las jornadas
		$sql="INSERT INTO t_jornadas(ID_EQUI_CAS,ID_EQUI_VIS,ESTADO,NUM_JOR,ID_EVE,GRUPO) 
							VALUES (".$valores[$i].",
									".$valores2[$i].",
									".$estado.",
									".$jornada.",
									".$_POST['id_evento'].",
									".$a.");";
		$query=mysql_query($sql, $conn);
		$conta++;
	}
}
	
	echo "<script type=\"text/javascript\">
				alert('Jornadas registradas correctamente');
				document.location.href='../jor_grupos.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['id_nombtorneo']."';
			</script>";
}
else
{
	echo "<script type=\"text/javascript\">
		alert('Los campos con asterisco (*) son requeridos');
		history.go(-1);
	</script>";
}


?>