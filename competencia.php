<link rel="stylesheet" type="text/css" href="style2.css" />
<link rel="stylesheet" href="css/utiles.css" type="text/css" />
<?php
include('admin/conexiones/conec.php');
$pg=$_GET['pg'];

if (!isset($pg)){
$pg = 0; // $pg es la pagina actual
}
$cantidad=6; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_documentos WHERE TIPO=3 ORDER BY ID LIMIT $inicial,$cantidad";
$cad = mysql_db_query($bd,$pegar) or die (mysql_error());//habia error porq puso variable $bd y era $base_de_datos

$contar = "SELECT * FROM t_documentos WHERE TIPO=3 ORDER BY ID"; 
$contarok= mysql_db_query($bd,$contar);//mismo error q en la linea 29
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
?><table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_01.png) no-repeat; width:1062px; height:14px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/otras_img/otro_02.png) repeat-y; width:14px; height:284px;">
			</td>
		<td style="background:url(img/otras_img/otro_03.png) repeat-y; width:1035px; height:284px;" valign="top">
       	<center>
        	<font face="Comic Sans MS, cursive" size="+2" color="#0066CC"> Archivos de comite de competencia</font>
       	</center>
       	<font color="#333333">
        	<center>
                <a href="http://www.coparotativapz.org/index.php?pag=disciplinario.php" class="hiper">
                	<img src="img_doc/flecha.jpg" width="20" height="15" style="border:none;" />Disciplinario
                </a> 
                &ensp;
                <a href="http://www.coparotativapz.org/index.php?pag=reglamento.php" class="hiper">
                	<img src="img_doc/flecha.jpg" width="20" height="15" style="border:none;" />Reglamento
                </a>  
                &ensp; 
                <a href="http://www.coparotativapz.org/index.php?pag=otros.php" class="hiper">
                	<img src="img_doc/flecha.jpg" width="20" height="15" style="border:none;" />Otros
                </a>
           	</center>
       	</font>
		<?php    
		if ($total_records > 0){
			echo'
			<table border="0" align="center" width="90%">
				<tr>';
				$total=0;
				while ($row=mysql_fetch_assoc($cad)){
					if($total < 3){
						echo'
						<td>
							<table>
								<tr>
									<td rowspan="2">
										<img src="img_doc/images.jpg" width="150px">
									</td>
									<td width="170px">
										<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif" size="+1">Asunto:</font> 
										<font face="Arial, Helvetica, sans-serif">	'.$row['ASUNTO'].'</font>
									</td>
								</tr>
								<tr valign="top">
									<td width="170px">
										<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif" size="+1">Fecha: </font>
										<font face="Arial, Helvetica, sans-serif">'.$row['FECHA'].'</font>
									</td>
								</tr>
								<tr>
									<td width="150px" colspan="2" valign="top" align="left">			
										<a href="admin/'.$row['URL_DOCUMENTO'].'" target="_blank" onclick="window.open('.$row['URL_DOCUMENTO'].')" class="hiper">
											<img src="img_doc/ver.gif" style="border:none;">Ver
										</a>
										<a href="descarga.php?file='.$row['URL_DOCUMENTO'].'" class="hiper">
											<img src="img_doc/descarga.png" style="border:none;">Descargar
										</a>
									</td>
								</tr>
							</table>
						</td>';
						$total=$total+1;
					}
					else{
						echo '
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td rowspan="2">
											<img src="img_doc/images.jpg" width="150px">
										</td>
										<td width="170px">
											<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif" size="+1">Asunto:</font> 
											<font face="Arial, Helvetica, sans-serif">	'.$row['ASUNTO'].'</font>
										</td>
									</tr>
									<tr valign="top">
										<td width="170px">
											<font color="#0066CC" face="Trebuchet MS, Arial, Helvetica, sans-serif" size="+1">Fecha: </font>
											<font face="Arial, Helvetica, sans-serif">'.$row['FECHA'].'</font>
										</td>
									</tr>
									<tr>
										<td colspan="2" valign="top" align="left">
											<a href="admin/'.$row['URL_DOCUMENTO'].'" target="_blank" onclick="window.open('.$row['URL_DOCUMENTO'].')" class="hiper">
												<img src="img_doc/ver.gif" style="border:none;">Ver
											</a>
											&ensp;
											<a href="descarga.php?file='.$row['URL_DOCUMENTO'].'" class="hiper">
												<img src="img_doc/descarga.png" style="border:none;">Descargar
											</a>
										</td>	
									</tr>
								</table>
							</td>';	
							$total=1;
					}
				}
				echo '
				</tr>
			</table>';
			}
			else{
				echo '<center>No hay datos que mostrar</center>';
			}

			// Cerramos la conexión a la base
			$conn=mysql_close($conn);

			// Creando los enlaces de paginación
			echo '<p><h3><center>'; 
			if ($pg != 0)  { 
				$url = $pg - 1; 
				echo '<a href="index.php?pag=competencia.php&pg='.$url.'" class="hiper">&laquo; Anterior</a>&nbsp;'; 
			} 
			else { 
				echo " "; 
			} 
			
			for ($i = 0; $i <= $pages; $i++) { 
				if ($i == $pg) { 
					if ($i == "0") { 
						echo "<b> 1 </b>"; 
					} 
					else { 
						$j = $i+1; 
						echo "<b> ".$j." </b>"; 
					} 
				} 
				else{	 
					if ($i == "0") { 
						echo '<a href="index.php?pag=competencia.php&pg='.$i.'" class="hiper">1</a> '; 
					} 
					else { 
						echo '<a href="index.php?pag=competencia.php&pg='.$i.'" class="hiper">'; 
						$j = $i+1; 
						echo $j."</a> "; 
					} 
				}	 
			} 
			if ($pg < $pages) { 
				$url = $pg + 1; 
				echo '<a href="index.php?pag=competencia.php&pg='.$url.'" class="hiper">Siguiente &raquo; </a>'; 
			} 
			echo "</center></h3></p>"; 
			?>
			</td>
		<td style="background:url(img/otras_img/otro_04.png) repeat-y; width:13px; height:284px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_05.png) no-repeat; width:1062px; height:71px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td style="background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;" valign="top">
        <?php include('content_secundario.html');?>
			</td>
		<td style="background:url(img/img_ini/inicio_22.png) repeat-y; width:13px; height:66px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ini/inicio_23.png) no-repeat; width:1062px; height:18px;">
			</td>
	</tr>
</table>