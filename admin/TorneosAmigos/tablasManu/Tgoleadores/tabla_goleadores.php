<script src="../../js/funciones.js" type="text/javascript"></script>
<?php
include('../../conexiones/conec_cookies.php');

$sql="SELECT * FROM T_GOL_AMI WHERE ID_TORNEO=".$_GET['ID']." ORDER BY TG DESC";
$query=mysql_query($sql,$conn) or die (mysql_error());
$total_records=mysql_num_rows($query);

$contenedor_temp='';
$gol_temp='0';
$cant_jorn;
$header_jornadas;
$total_string;

$sql_temp="SELECT MAX(STJ) FROM T_GOL_AMI WHERE ID_TORNEO=".$_GET['ID'];
$var_stj=mysql_query($sql_temp,$conn);
while($ret=mysql_fetch_assoc($var_stj))
{
	$cant_jorn=$ret['MAX(STJ)'];
}
$total_string=0;
if($cant_jorn>0)
{
	$sql_end="SELECT JORNADAS FROM T_GOL_AMI WHERE STJ=".$cant_jorn." AND ID_TORNEO=".$_GET['ID']." LIMIT 1";
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
    		<a href="add_player.php?ID=<?php echo $_GET['ID']?>&NOMB=<?php echo $_GET['NOMB'];?>">
        		<img src="img/add_player.png" align="middle" title="Agregar" style="margin-left:25px;" width="80px"/>
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
        <th scope="col">Nombre</th>
        <th scope="col">Primer<br />Apellido</th>
        <th scope="col">Segundo<br /> Apellido</th>
        <th scope="col">Equipo</th>
        <th scope="col">Total<br /> Goles</th>
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
                echo'<th scope="col">'.$contenedor_temp.'</th>';
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
			 echo' <tr>  
			  <td id="eliminar">
				<a href="eliminar_goleador.php?id_torneo='.$_GET['ID'].'&id='.$row['ID'].'&NOMB='.$_GET['NOMB'].'" 
					onclick="javascript: return sure();">
					<img src="img/icono-eliminar.gif" title="Eliminar Jugador" /> 
				</a>
			  </td>
			  
			  <td id="editar">
			  <a href="editar_goleo.php?id_torneo='.$_GET['ID'].'&id='.$row['ID'].'&NOMB='.$_GET['NOMB'].'"   >
					<img src="img/icono_editar.png" title="Editar" /></a>
			  </td>
			   
			  <td id="add">
					<a href="agregar_gj.php?id_torneo='.$_GET['ID'].'&id='.$row['ID'].'&NOMB='.$_GET['NOMB'].'"><img src="img/more.JPG" title="Agregar goles y jornadas"/></a>
			  </td>
			  
			  <td id="nombre" style="vertical-align:top;">
			      '.$row['NOMBRE'].' 
			  </td>';
			  
			  echo'<td id="apellido1" style="vertical-align:top;">
			     '.$row['APELLIDO1'].'
			  </td>
			  
			  <td id="apellido2" style="vertical-align:top;">
			  	 '.$row['APELLIDO2'].'
			  </td>
			  
			  <td id="equipo" style="vertical-align:top;">
			  	 '.$row['EQUIPO'].'
			  </td>';
			  
			 
			  echo'<td id="goles" style="vertical-align:top;">
			  '.$row['TG'].'
			  </td>';
			  
			  for($i=0;$i<=strlen($row['GOLES']);$i++)
			  {
				  $compara=substr($row['GOLES'],$i,1);
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
		   echo'</tr>';
	 }
  ?>
</table>
   
