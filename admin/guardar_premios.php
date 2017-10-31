<?php
include('conexiones/conec_cookies.php');

list($primero_llaves, $segundo_llaves,$tercero_llaves,$cuarto_llaves,$quinto_llaves) = explode(",",$_POST['hdn_pr_llaves']);
list($primero_m_batido, $segundo_m_batido) = explode(",",$_POST['hdn_m_batido']);
list($primero_m_ofensiva, $segundo_m_ofensiva) = explode(",",$_POST['hdn_m_ofensiva']);
list($primero_m_disiplinado, $segundo_m_disiplinado) = explode(",",$_POST['hdn_m_disiplinado']);
list($primero_goleador, $segundo_goleador) = explode(",",$_POST['hdn_goleador']);
list($primero_recopa, $segundo_recopa) = explode(",",$_POST['hdn_recopa']);

if(!(isset($quinto_llaves))&&
	!(isset($segundo_m_batido))&&
 	!(isset($segundo_m_ofensiva))&&
	!(isset($segundo_m_disiplinado))&&
	!(isset($segundo_goleador))&& 
	!(isset($segundo_recopa))&&
	isset($primero_llaves)&&($primero_llaves!='')&&
	isset($segundo_llaves)&&($segundo_llaves!='')&&
	isset($tercero_llaves)&&($tercero_llaves!='')&&
	isset($cuarto_llaves)&&($cuarto_llaves!='')&&
	isset($primero_m_batido)&&($primero_m_batido!='')&&
	isset($primero_m_ofensiva)&&($primero_m_ofensiva!='')&&
	isset($primero_m_disiplinado)&&($primero_m_disiplinado!='')&&
	isset($primero_goleador)&&($primero_goleador!='')&&
	isset($primero_recopa)&&($primero_recopa!='')){
	  
   //colorcar las posiciones en blanco
	$sql_blanco="UPDATE t_est_equi SET
		POSICION=5,
		PR_MEN_BATIDO=0,
		PR_MEJ_OFEN=0,
		PR_MAS_DISC=0,
		PR_CAM_RECOPA=0
	 	WHERE ID_TORNEO=".$_POST['hdn_id_torneo'];
		
	$query_blanco=mysql_query($sql_blanco,$conn);
	
		$sql_blanco="UPDATE t_est_jug_disc SET
		PR_GOL=0
	 	WHERE ID_TORNEO=".$_POST['hdn_id_torneo'];
		
	$query_blanco=mysql_query($sql_blanco,$conn);
	  
	 //guardar las posiciones en la llaves
	$sql_llaves1="UPDATE t_est_equi SET
		POSICION=1
	 	WHERE ID_EQUI=".$primero_llaves." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_llaves1=mysql_query($sql_llaves1,$conn);
	
	$sql_llaves2="UPDATE t_est_equi SET
		POSICION=2
	 	WHERE ID_EQUI=".$segundo_llaves." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_llaves2=mysql_query($sql_llaves2,$conn);
	
	$sql_llaves3="UPDATE t_est_equi SET
		POSICION=3
	 	WHERE ID_EQUI=".$tercero_llaves." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_llaves3=mysql_query($sql_llaves3,$conn);
	
	$sql_llaves4="UPDATE t_est_equi SET
		POSICION=4
	 	WHERE ID_EQUI=".$cuarto_llaves." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_llaves4=mysql_query($sql_llaves4,$conn);
	
	//arco menos batido  
	$sql_m_batido="UPDATE t_est_equi SET
		PR_MEN_BATIDO=1
	 	WHERE ID_EQUI=".$primero_m_batido." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_m_batido=mysql_query($sql_m_batido,$conn);  
	
	//mejor ofensiva
	$sql_m_ofensiva="UPDATE t_est_equi SET
		PR_MEJ_OFEN=1
	 	WHERE ID_EQUI=".$primero_m_ofensiva." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_m_ofensiva=mysql_query($sql_m_ofensiva,$conn); 
	
	//mas disiplinados
	$sql_m_disiplianado="UPDATE t_est_equi SET
		PR_MAS_DISC=1
	 	WHERE ID_EQUI=".$primero_m_disiplinado." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_m_disiplianado=mysql_query($sql_m_disiplianado,$conn); 
	
	//campeon recopa
	$sql_recopa="UPDATE t_est_equi SET
		PR_CAM_RECOPA=1
	 	WHERE ID_EQUI=".$primero_recopa." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_recopa=mysql_query($sql_recopa,$conn); 
	
	//campeon goleador
	$sql_goleador="UPDATE t_est_jug_disc SET
		PR_GOL=1
	 	WHERE ID_PERSONA=".$primero_goleador." AND ID_TORNEO=".$_POST['hdn_id_torneo'];
	$query_goleador=mysql_query($sql_goleador,$conn); 
	  
	echo "<script type=\"text/javascript\">
		alert('Se han guardado los premios correctamente');
		document.location.href='premios.php';
	</script>";
	  
}
else{
		echo "<script type=\"text/javascript\">
			alert('Faltan o se han ingresado campos de mas');
			history.go(-1);
		</script>";
}
?>