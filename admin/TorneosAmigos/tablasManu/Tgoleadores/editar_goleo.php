<?php
include('../../conexiones/conec_cookies.php');
$sql="SELECT * FROM T_GOL_AMI WHERE ID=".$_GET['id']."";
$query=mysql_query($sql,$conn) or die(mysql_error());

$compara='';
$jor_temp='';
$var_final='';
$b=0;
while($row=mysql_fetch_assoc($query))
{
	$goles=$row['GOLES'];
	$jornadas=$row['JORNADAS'];
?>
    <form action="save_edit.php" method="post" style="margin-left:50px; margin-top:20px;">
		<table id="datos_personales">
        <div id="bloque1">
            <tr>
            	<td>Nombre: </td>
                <td align="left"><input type="text" name="nombre"  value="<?php echo $row['NOMBRE'];?>" style="text-align:center;" /></td>
            <tr> 
            	<td>Apellido1: </td>
                <td align="left"><input type="text" name="apellido1" value="<?php echo $row['APELLIDO1']?>" style="text-align:center;" /></td>
            <tr> 
            	<td>Apellido2:</td> 
                <td align="left"><input type="text" name="apellido2" value="<?php echo $row['APELLIDO2']?>" style="text-align:center;" /></td>
            <tr> 
            	<td>Equipo: </td>
                <td align="left"><input type="text" name="equipo" value="<?php echo $row['EQUIPO']?>" style="text-align:center;" /></td>
            </tr>    
		</div>
        </table>  
          
		<table>
           <div id="bloque2">
           <tr>
           <td>#Jornada:</td>
           <?php
		     $cj=0; /**Contador de jornadas**/
			 $cnj='J';
			 
			 for($i=0;$i<=strlen($jornadas);$i++)
			 {
				 $check=substr($jornadas,$i,1);
				 if(is_numeric($check))
				 {		 
					  $jor_temp=$jor_temp.$check;
					  $b=1;
				 }
				 else
				 {
					 if($b=='1')
					 {
						 $cj=$cj+1;
					  $cnj='J'.$cj;
						$var_final=$jor_temp;
						echo'<td>J<input type="text" size="1" value="'.$var_final.'" name="'.$cnj.'" style="text-align:center;" /></td>';
						$jor_temp='';
					 }
					 else
					 {
						 $jor_temp='';
					 }
					 $b=0;
				 }//cierre del else
			 }
			 
		   ?>
           
           </tr>
           
           	<tr>
               <td>Goles:</td>
               <?php
			   $contenedor_temp='';
			   $ar_goles=array();
			   $cg=0;/**Contador goles **/
			   $cng='g'; /**nombre para los input + cg**/
                for($i=0;$i<=strlen($goles);$i++)
                 {
                     $compara=substr($goles,$i,1);
                     if($compara!=';')
                     {
                     $contenedor_temp=$contenedor_temp.$compara;
                     }
                     else
                     {
						 $cg=$cg+1;
						 $cng='g'.$cg;
						 /**echo $ar_goles[$i];**/
						 echo'<td><input type="text" value="'.$contenedor_temp.'" size="2" name="'.$cng.'" style="text-align:center;" /></td>';
                         $contenedor_temp='';
                     }
                    
                 }
              
               ?>
               
            </tr>
           </div>
           </table>     
           
           		<input type="hidden" name="for_goles" value="<?php echo $cg;?>" />
                <input type="hidden" name="for_jornadas" value="<?php echo $cj;?>" />
                <input type="hidden" name="id_torneo" value="<?php echo $_GET['id_torneo'];?>" />
                <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB'];?>" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                
                <input type="submit" value="Guardar" />
                <input type="button" value="Cancelar" onclick="document.location.href='tabla_goleadores.php?ID=<?php echo $_GET['id_torneo']; ?>&NOMB=<?php echo $_GET['NOMB'];?>';"/>
           
    </form>
 <?php
}
?>