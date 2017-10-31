<?php
include('../../conexiones/conec_cookies.php');
 $flag_goles=0;
 $flag_jornadas=0;
 $guardar_amarillas='';
 $guardar_rojas='';
 $guardar_jornadas='';
 $gol_temp='';
if (
	(isset($_POST['nombre']) and ($_POST['nombre'] !=''))
	)
	{
		
		/**For para verificar campos de goles sean numericoos**/
		for($i=1;$i<=$_POST['for_goles'];$i++)
		{ 
			
			/**echo $_POST['g'.$i.''].'   ';**/
			if(is_numeric($_POST['g'.$i.'']))
			{
				$var_temp=$_POST['g'.$i].';';
				$guardar_amarillas=$guardar_amarillas.$var_temp;
			}
			else
			{	
				$flag_goles=1;
			}
			
		}/** termina for de goles**/
		
		
		
			/**For para verificar campos de goles sean numericoos**/
		for($i=1;$i<=$_POST['for_rojas'];$i++)
		{ 
			
			/**echo $_POST['g'.$i.''].'   ';**/
			if(is_numeric($_POST['r'.$i.'']))
			{
				$var_temp=$_POST['r'.$i].';';
				$guardar_rojas=$guardar_rojas.$var_temp;
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
			echo "<script type=\"text/javascript\">alert('Error datos no numericos en Amarillas o Rojas');history.go(-1);</script>";
		}
		else
		{
			/**for para ver la cantidad de goles**/
			 for($i=0;$i<=strlen($guardar_amarillas);$i++)
			  {
				  $compara=substr($guardar_amarillas,$i,1);
				  if($compara!=';')
				 {
				 $gol_temp=$gol_temp+$compara;/**Gol_temp guarda total de goles  gol_temp para tta**/
				 }
				 
			  } 
			  /**Termina for**/
			  $stj=strlen($guardar_jornadas);
			  
			  
			  $sql = "UPDATE T_CON_DIS_AMI SET
			NOMBRE_EQUI = '".$_POST['nombre']."',
			JORNADAS = '".$guardar_jornadas."',
			AMARILLAS = '".$guardar_amarillas."',
			ROJAS= '".$guardar_rojas."',
			TTA = '".$gol_temp."',
			STA = '".$stj."',
			ID_TORNEO = '".$_POST['id_torneo']."'
			WHERE ID = '".$_POST['id']."'";
			  
			  $query = mysql_query($sql, $conn)or die(mysql_error());
		echo "<script type=\"text/javascript\">alert('Datos Editados Correctamente');document.location.href='ctrl_disc.php?ID=".$_POST['id_torneo']."&NOMB=".$_POST['NOMB']."';</script>";
		}
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Por favor complete la informacion');history.go(-1);</script>"; 
	}
?>