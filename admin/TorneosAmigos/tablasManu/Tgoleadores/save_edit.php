<?php
include('../../conexiones/conec_cookies.php');
 $flag_goles=0;
 $flag_jornadas=0;
 $guardar_goles='';
 $guardar_jornadas='';
 $gol_temp='';
if (
	(isset($_POST['nombre']) and ($_POST['nombre'] !='')) and
	 (isset($_POST['apellido1']) and ($_POST['apellido1'] !=''))and
	  (isset($_POST['apellido2']) and ($_POST['apellido2'] !=''))and
	  (isset($_POST['equipo']) and ($_POST['equipo'] !=''))
	)
	{
		
		/**For para verificar campos de goles sean numericoos**/
		for($i=1;$i<=$_POST['for_goles'];$i++)
		{ 
			
			/**echo $_POST['g'.$i.''].'   ';**/
			if(is_numeric($_POST['g'.$i.'']))
			{
				$var_temp=$_POST['g'.$i].';';
				$guardar_goles=$guardar_goles.$var_temp;
			}
			else
			{	
				$flag_goles=1;
			}
			
		}/** termina for de goles**/
		/**For para las jornadas**/
		for($i=1;$i<=$_POST['for_jornadas'];$i++)
		{
			if(is_numeric($_POST['J'.$i.'']))
			{
				$var_temp_j=$_POST['J'.$i].';';
				$guardar_jornadas=$guardar_jornadas.$var_temp_j;
			}
			else
				 $flag_jornadas=1;
			 
		}
		/**Termina for para las jornaas**/
		if($flag_goles>0||$flag_jornadas>0)
		{
			echo "<script type=\"text/javascript\">alert('Error datos no numericos en jornadas o goles');history.go(-1);</script>";
		}
		else
		{
			/**for para ver la cantidad de goles**/
			 for($i=0;$i<=strlen($guardar_goles);$i++)
			  {
				  $compara=substr($guardar_goles,$i,1);
				  if($compara!=';')
				 {
				 $gol_temp=$gol_temp+$compara;/**Gol_temp guarda total de goles**/
				 }
				 
			  } 
			  /**Termina for**/
			  $stj=strlen($guardar_jornadas);
			  
			  
			  $sql = "UPDATE T_GOL_AMI SET
			NOMBRE = '".$_POST['nombre']."',
			APELLIDO1 = '".$_POST['apellido1']."',
			APELLIDO2='".$_POST['apellido2']."',
			EQUIPO = '".$_POST['equipo']."',
			GOLES = '".$guardar_goles."',
			JORNADAS = '".$guardar_jornadas."',
			TG = '".$gol_temp."',
			STJ = '".$stj."',
			ID_TORNEO = '".$_POST['id_torneo']."'
			WHERE ID = '".$_POST['id']."'";
			  
			  $query = mysql_query($sql, $conn)or die(mysql_error());
		echo "<script type=\"text/javascript\">alert('Datos Editados Correctamente');document.location.href='tabla_goleadores.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';</script>";
		}
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>"; 
	}
?>