<?php
 include('../../conexiones/conec_cookies.php');
 	
	//-----borrar torneo
	$sql="DELETE FROM t_torneo WHERE ID='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	
	//---------escuger eventos
	$sql="SELECT * FROM t_eventos WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	while($row=mysql_fetch_assoc($query)){
		
		//------borrar relaciones equipo-evento
		$cadena="DELETE FROM t_even_equip WHERE ID_EVEN='".$row['ID']."'";
		$consulta=mysql_query($cadena,$conn);
		
		//BORRAR LAS JORNADAS
		$cadena="DELETE FROM t_jornadas WHERE ID_EVEN='".$row['ID']."'";
		$consulta=mysql_query($cadena,$conn);
	}
	
	//---------borrar eventos---
	$sql="DELETE FROM t_eventos WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);

	$sql="DELETE FROM t_est_equi WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	
	//BORRAR LA TABLA GOLEADORES DDE AMIGOS
	$sql="DELETE FROM T_GOL_AMI WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	
	//BORRAR LA TABLA DOCUMENTOS DDE AMIGOS
	$sql="DELETE FROM T_DOC_AMI WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	
	//BORRAR LA TABLA DOCUMENTOS DDE AMIGOS
	$sql="DELETE FROM T_CON_DIS_AMI WHERE ID_TORNEO='".$_GET['ID']."'";
	$query=mysql_query($sql,$conn);
	 
	echo "<script type=\"text/javascript\">
	 		alert('Torneo eliminado correctamente');
	 		document.location.href='../../index.php';
	</script>";
?>