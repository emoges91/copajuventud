<?php
 include('../../conexiones/conec_cookies.php');
 $sql="SELECT * FROM T_GOL_AMI WHERE ID=".$_GET['id']."";
 $query=mysql_query($sql,$conn) or die (mysql_error());
 $total_records=mysql_num_rows($query);
 $var_final='';
 $compara='';
 $jor_temp='';
 $b=0;
 
?><head>
<link href="css/css_goleadores.css" type="text/css" rel="stylesheet" />
</head>

<div id="formulario">
   <table border="1" style="width:auto;" id="hor-minimalist-b">
     <tr>
      <thead>	
     	<th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Equipo</th>
        <th scope="col">Jornada #</th>
        <th scope="col">Goles</th>
      </thead>
     </tr>
     <form action="save_part1.php" method="post" enctype="multipart/form-data">
     <tr>
      <?php

	   while($row=mysql_fetch_assoc($query))
	   { 
       echo'<td>'.$row['NOMBRE'].'</td>
       		<td>'.$row['APELLIDO1'].' '.$row['APELLIDO2'].' </td>
       		<td>'.$row['EQUIPO'].'</td>';
			$var_jornadas= $row['JORNADAS'];
			$var_goles=$row['GOLES'];
			$equipo=$row['EQUIPO'];
			$nombre=$row['NOMBRE'];
			$apellido1=$row['APELLIDO1'];
			$apellido2=$row['APELLIDO2'];
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
		 	
	 		}
	  }//termina el while
	   }
	   $var_final=$var_final+1;
	   ?>

       <td><input type="text" name="jornada" width="50px" value="<?php echo $var_final; ?>" readonly="readonly" />
       </td>      <td><input type="text" name="goles" width="50px" /></td>
       <input type="hidden" value="<?php echo $_GET['id_torneo']?>" name="id_torneo" />
       <input type="hidden" value="<?php echo $_GET['NOMB']?>" name="NOMB" />
       <input type="hidden" value="<?php echo $_GET['id']?> " name="id" />
       <input type="hidden" value="<?php echo $var_jornadas?>" name="total_jornadas" />
       <input type="hidden" value="<?php echo $var_goles?>" name="total_goles" />
        <input type="hidden" value="<?php echo $equipo?>" name="equipo" />
        <input type="hidden" value="<?php echo $apellido1?>" name="apellido1" />
        <input type="hidden" value="<?php echo $apellido2?>" name="apellido2" />
        <input type="hidden" value="<?php echo $nombre?>" name="nombre" />
        <td><input type="submit" value="Guardar" /></td>
     	<td><input type="button" value="Atras" onClick="document.location.href='tabla_goleadores.php?ID=<?php echo $_GET['id_torneo']?>&NOMB=<?php echo $_GET['NOMB']?>';" /></td>
     </tr>
    
     </form>
   </table>
</div>