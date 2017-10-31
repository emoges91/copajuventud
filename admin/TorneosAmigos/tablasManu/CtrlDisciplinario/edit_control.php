<?php
include('../../conexiones/conec_cookies.php');
$sql="SELECT * FROM T_CON_DIS_AMI WHERE ID=".$_GET['id']."";
$query=mysql_query($sql,$conn) or die(mysql_error());

$compara='';
$jor_temp='';
$var_final='';
$b=0;
while($row=mysql_fetch_assoc($query))
{
	$amarillas=$row['AMARILLAS'];
	$rojas=$row['ROJAS'];
	$jornadas=$row['JORNADAS'];
?>
    <form action="save_edit.php" method="post" style="margin-left:50px; margin-top:20px;">
		<table id="datos_personales">
        <div id="bloque1">
            <tr>
            	<td>Nombre: </td>
                <td align="left"><input type="text" name="nombre"  value="<?php echo $row['NOMBRE_EQUI'];?>" style="text-align:center;" /></td>
            <tr> 
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
						echo'<td>J<input type="text" size="1" readonly="readonly" value="'.$var_final.'" name="'.$cnj.'" style="text-align:center;" /></td>';
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
               <td><img src="img/ta.gif" align="right" /></td>
               <?php
			   $contenedor_temp='';
			   $ar_goles=array();
			   $cg=0;/**Contador goles **/
			   $cng='g'; /**nombre para los input + cg**/
                for($i=0;$i<=strlen($amarillas);$i++)
                 {
                     $compara=substr($amarillas,$i,1);
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
            
           
           <tr>
               <td><img src="img/tr.gif" align="right" /></td>
               <?php
			   $contenedor_temp='';
			   $arr_goles=array();
			   $cr=0;/**Contador goles **/
			   $cnr='r'; /**nombre para los input + cg**/
                for($i=0;$i<=strlen($rojas);$i++)
                 {
                     $compara=substr($rojas,$i,1);
                     if($compara!=';')
                     {
                     $contenedor_temp=$contenedor_temp.$compara;
                     }
                     else
                     {
						 $cr=$cr+1;
						 $cnr='r'.$cr;
						 /**echo $ar_goles[$i];**/
						 echo'<td><input type="text" value="'.$contenedor_temp.'" size="2" name="'.$cnr.'" style="text-align:center;" /></td>';
                         $contenedor_temp='';
                     }
                    
                 }
              
               ?>
               
            </tr>
            
           </div>
           </table>     
           
           		<input type="hidden" name="for_goles" value="<?php echo $cg;?>" />
                <input type="hidden" name="for_jornadas" value="<?php echo $cj;?>" />
                <input type="hidden" name="for_rojas" value="<?php echo $cr ?>" />
                <input type="hidden" name="id_torneo" value="<?php echo $_GET['id_torneo'];?>" />
                <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB'];?>" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                
                <input type="submit" value="Guardar" />
                <input type="button" value="Cancelar" onclick="document.location.href='ctrl_disc.php?ID=<?php echo $_GET['id_torneo']; ?>&NOMB=<?php echo $_GET['NOMB'];?>';"/>
           
    </form>
 <?php
}
?>