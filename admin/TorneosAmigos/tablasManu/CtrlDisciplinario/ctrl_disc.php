<script src="../../js/funciones.js" type="text/javascript"></script>
<?php
include('../../conexiones/conec_cookies.php');

$sql="SELECT * FROM T_CON_DIS_AMI WHERE ID_TORNEO=".$_GET['ID']." ORDER BY TTA DESC";
$query=mysql_query($sql,$conn) or die (mysql_error());
$total_records=mysql_num_rows($query);

$contenedor_temp='';
$gol_temp='0';
$cant_jorn;
$header_jornadas;
$total_string;
$sum=0;
$ttr='';


$sql_temp="SELECT MAX(STA) FROM T_CON_DIS_AMI WHERE ID_TORNEO=".$_GET['ID'];
$var_stj=mysql_query($sql_temp,$conn);
while($ret=mysql_fetch_assoc($var_stj))
{
	$cant_jorn=$ret['MAX(STA)'];
}
$total_string=0;
if($cant_jorn>0)
{
	$sql_end="SELECT JORNADAS FROM T_CON_DIS_AMI WHERE STA=".$cant_jorn." AND ID_TORNEO=".$_GET['ID']." LIMIT 1";
	$jornadas=mysql_query($sql_end,$conn);
	$total_string=mysql_num_rows($jornadas);
	while($ret=mysql_fetch_assoc($jornadas))
	{
		$header_jornadas =$ret['JORNADAS'];
		
	}
}
$dire='../../';
include_once('../../mostrar_torneo.php');
?>
<link href="css/css_goleadores.css" type="text/css" rel="stylesheet" />
 
<table width="100%">
	<tr>
    	<td align="right">
    		<a href="add.php?id_torneo=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">
            	<img src="img/add_play.png" align="middle" title="Agregar" width="80px"/>
          	</a>
 		</td>
  	</tr>
</table>

<table  id="hor-minimalist-b" cellpadding="2" >
   <tr>
       <!--Empieza header de la tabla-->
      <thead> 
   	   <tr id="header">
        <td></td>
        <td></td>
        <td></td>
        <th scope="col">Equipo</th>
        <th scope="col">Total</th>
        <?php
		if($total_string>'0')
		{
         for($i=0;$i<=strlen($header_jornadas);$i++)
         {
             $compara=substr($header_jornadas,$i,1);
             if($compara!=';')
             {
              
             $contenedor_temp=$contenedor_temp.$compara;
             }
             else
             {
                echo'<th scope="col">J'.$contenedor_temp.'</th>';
                 $contenedor_temp='';
             }     
         }
		}
		 ?>
       </tr>
      </thead>
    </tr> 
       <!--Termina header de la tabla--> 
  <?php     
     while($row=mysql_fetch_assoc($query))
	 { 
	      $str_rojas=$row['ROJAS'];
		  
			 echo' <tr>  
			  <td><a href="del_goleador.php?id_torneo='.$_GET['ID'].'&id='.$row['ID'].'&NOMB='.$_GET['NOMB'].'" onclick="javascript: return sure();"><img src="../Tgoleadores/img/icono-eliminar.gif" title="Eliminar" /></a></td>
		  <td><a href="edit_control.php?id_torneo='.$_GET['ID'].'&id='.$row['ID'].'&NOMB='.$_GET['NOMB'].'"><img src="../Tgoleadores/img/icono_editar.png" title="Editar" /></a></td>
		 <td><a href="add_ra.php?id_torneo='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'&id='.$row['ID'].'"><img src="img/more.JPG"></td>
			  
			  <td style="vertical-align:top;">
			      '.$row['NOMBRE_EQUI'].' 
			  </td>';
			  
			  echo'<td style="vertical-align:top;">
			     <img src="img/ta.gif"/>'.$row['TTA'].'
			  </td>
			  ';
			  
			  for($i=0;$i<=strlen($row['AMARILLAS']);$i++)
			  {
				  $compara=substr($row['AMARILLAS'],$i,1);
				  if($compara!=';')
				 {
				 $contenedor_temp=$contenedor_temp.$compara;
				 $gol_temp=$gol_temp+$compara;
				 }
				 else
				 {
				  /*Aplicar for para columna para goles y jornadas */
				  
				  echo'<td id="jornada" style="vertical-align:top;">';
					echo $contenedor_temp;
					$contenedor_temp='';
				  echo'</td>';
				 }
				 
			  }
			  
			  /*Debe terminar el for*/
			  
			   for($i=0;$i<=strlen($str_rojas);$i++)
			  {
				  $sum=substr($str_rojas,$i,1);
				  if($sum!=';')
				 {
				 $ttr=$ttr+$sum;
				 } 
			  } 
			  if ($ttr==0)
			  {
				  $ttr='';
			  }
			  $sum=0;
		   echo'</tr>
		   <tr>
		   <td></td>
		   <td></td>
		   <td></td>
		   <td></td>
		   <td><img src="img/tr.gif">'.$ttr.'';
		   		for($i=0;$i<=strlen($str_rojas);$i++)
			  {
				  $compara=substr($str_rojas,$i,1);
				  if($compara!=';')
				 {
				 $contenedor_temp=$contenedor_temp.$compara;
				 $gol_temp=$gol_temp+$compara;
				 }
				 else
				 {
				  /*Aplicar for para columna para goles y jornadas */
				  
				  echo'<td style="vertical-align:top;">';
					echo $contenedor_temp;
					$contenedor_temp='';
				  echo'</td>';
				 }
				 
			  }
			  $ttr='';
		   echo'</td>
		   </tr>
		  ';
	 }
  ?>
</table>
   
