<script src="../../js/funciones.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>
<link href="css/datos_manuales.css" type="text/css" rel="stylesheet" />
<?php
include('../../conexiones/conec_cookies.php');
include ('../../FPHP/funciones.php');

$dire='../../';
include_once('../../mostrar_torneo.php'); 

$consulta="SELECT * FROM T_DOC_AMI WHERE TIPO=0 AND ID_TORNEO=".$_GET['ID']." ORDER BY ID DESC";
$cadena=mysql_query($consulta,$conn)or die (mysql_error());
$total_records = mysql_num_rows($cadena);
 
 
$consulta2="SELECT * FROM T_DOC_AMI WHERE TIPO=1 AND ID_TORNEO=".$_GET['ID']." ORDER BY ID DESC";
$cadena2=mysql_query($consulta2,$conn)or die (mysql_error());
$total_records2 = mysql_num_rows($cadena2);
 

?>

<div id="Contenedor" align="center">
	<form action="guardar_doc.php" method="post"  enctype="multipart/form-data">
    	<div id="fecha">
    		Fecha:<input id="demo1" type="text" size="19" align="top" name="fecha">
            	<a href="javascript:NewCal('demo1','ddmmyyyy')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
   		</div>
   		<div id="descripcion">
   			Nota:
            <textarea rows="3" cols="25" name="descripcion"></textarea>
   		</div>
    	<div id="opcion">
        	Opcion:<input type="radio" value="0" name="datos" checked="checked"/>Jugadores Sancionados
            	   <input type="radio" value="1" name="datos" />Otros Documentos
    	</div>
   	    <div id="url_documento">
        	Archivo:<input type="file" name="documento"/>
        </div>
        <input type="hidden" name="id_tor" value="<?php echo $_GET['ID'] ?>"/>
        <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB'] ?>"/>
    <br />
		<div id="botones" align="right">
        	<input type="submit" value="Guardar" />
            <input type="reset" value="Limpiar"  />
        </div>    
   </form>
 </div>

<table id="mostrar" width="500px;">
<tr>
   <td style="vertical-align:top;">
         	<table align="center" >
            	<tr>
                	<td>
                    <div id="jugadores" align="center" >
                    
                      <div id="header" >
                      		<img src="img/IconoCarpeta.gif" />Documentos Jugadores
                      </div>
                      
					  <div id="a1">
                          
                           <table cellpadding="5px">
                           <?php
						   if($total_records>0)
						   {
							   while($row = mysql_fetch_assoc($cadena) )
							   {
								echo'<tr> 
									<td><a href="eliminar_doc.php?id='.$row['ID'].'&id_torneo='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'" onclick="javascript: return sure();"><img src="img/icono_eliminar.png" title="Eliminar" /></a></td>
									<td><a href="editar_doc.php?id='.$row['ID'].'&id_torneo='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'"><img src="img/icono_editar.png" title="Editar" /></a></td>
									<td>'.$row['FECHA'].'</td>
									<td>';?><?php echo substr($row['NOTAS'],0,30);echo'....'; echo'</td>
									<td><a href="'.$row['URL_DOC'].'" target="_blank"><img src="img/icono_descargar.jpg" title="Previsualizar" /></a></td>
								</tr>';
							   }
						   }
							?>
                           </table> 
                      </div>
                    
            		</div>
            		</td>
            	</tr>
            </table>
  	</td>
    <td style="vertical-align:top;" width="500px;">
   	
        	<table align="center" style=" vertical-align:top;">
            	<tr>
                	<td>
                    	<div id="otros" align="center" style="vertical-align:top;">
                        
                        <div id="header">
                      		<img src="img/IconoCarpeta.gif" />Otros Documentos
                        </div>
						
                        <div id="a1">
                        
                        	<table cellpadding="5px">
                            <?php
                           if($total_records2>0)
						   {
							   while($row2 = mysql_fetch_assoc($cadena2) )
							   {
								echo'<tr>
									<td><a href="eliminar_doc.php?id='.$row2['ID'].'&id_torneo='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'" onclick="javascript: return sure();"><img src="img/icono_eliminar.png" title="Eliminar" /></a></td>
									<td><a href="editar_doc.php?id='.$row2['ID'].'&id_torneo='.$_GET['ID'].'&NOMB='.$_GET['NOMB'].'"><img src="img/icono_editar.png" title="Editar" /></a></td>
									<td>'.$row2['FECHA'].'</td>
									<td>';?><?php echo substr($row2['NOTAS'],0,30);echo'....'; echo'</td>
									<td><a href="'.$row2['URL_DOC'].'" target="_blank"><img src="img/icono_descargar.jpg" title="Previsualizar" /></a></td>
								</tr>';
							   }
						   }
							?>
                           </table> 
                        </div>
                        </div>
            		</td>
            	</tr>
            </table>
	</td>
</tr>
</table>