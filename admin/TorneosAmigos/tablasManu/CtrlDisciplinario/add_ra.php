<?php
include('../../conexiones/conec_cookies.php');
$sql="SELECT * FROM T_CON_DIS_AMI WHERE ID=".$_GET['id']."";
$query=mysql_query($sql,$conn);
$var_final='';
$jor_temp='';
$b=0;
?>


   <?php echo'<table border="0">
   		<tr>';
			while ($row=mysql_fetch_assoc($query))
			{
				$temp_amarillas=$row['AMARILLAS'];
				$temp_rojas=$row['ROJAS'];
				$temp_jornadas=$row['JORNADAS'];
				$nombre_equi=$row['NOMBRE_EQUI'];
				
				for($i=0;$i<=strlen($row['JORNADAS']);$i++){
	 			$compara=substr($row['JORNADAS'],$i,1);
	 			if(is_numeric($compara))
	 			{
	   				$jor_temp=$jor_temp.$compara; 
	    			$b=1;
	 			}
	 			else
	 			{
		  			if($b=='1')
		  			{
		 				//echo $jor_temp.' ';
		 				$var_final=$jor_temp;
		  				$jor_temp='';
		 			}
		 			else
		 			{
			 			$jor_temp='';
		 			}
		 	   $b=0;
			 }//del for 
			
	 		}
			 $var_final=$var_final+1;
			}
		   echo '
				<td>Al equipo <font color="#0066FF">'.$nombre_equi.'</font> ingrese Tarjetas <img src="img/ta.gif"> y <img src="img/tr.gif"> de la </td>
			<td><u><b>Jornada # </u></b><font color="#0033FF">'.$var_final.'</font></td>	
		</tr>
   </table>';
   
   ?>
   <table>
 
       <form action="ra_save.php" method="post">
       <tr>
       <td>
       <img src="img/ta.gif" /><input type="text" name="amarillas" size="1"/>
       </td>
       <td>
       <img src="img/tr.gif" /><input type="text" name="rojas" size="1" />
       </td>
       <td>
         <input type="submit"  value="Guardar"/>
       </td>
       <td>
       <input type="hidden" name="nombre_equi" value="<?php echo $nombre_equi ?>" />
       <input type="hidden" name="id_torneo" value="<?php echo $_GET['id_torneo'] ?>" />
       <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB']?>" />
       <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
       <input type="hidden" name="jornadas" value="<?php echo $var_final ?>" />
       <input type="hidden" name="amarillas_temp" value="<?php echo $temp_amarillas ?>" />
       <input  type="hidden" name="jornadas_temp" value="<?php echo $temp_jornadas ?>" />
       <input type="hidden" name="rojas_temp" value="<?php echo $temp_rojas ?>" />
        <input type="button" value="Atras" onClick="document.location.href='ctrl_disc.php?ID=<?php echo $_GET['id_torneo']?>&NOMB=<?php echo $_GET['NOMB']?>';" />
       </td>
       </tr>
       </form>
   
   </table>