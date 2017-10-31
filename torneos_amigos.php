<?php
include('admin/conexiones/conec.php');

?>
<!-- Save for Web Slices (otro2.psd) -->
<table id="Tabla_01" width="1062" height="444" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr valign="bottom">
		<td colspan="3" style="background:url(img/img_ami/amigos1.png) no-repeat; width:1062px; height:7px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ami/amigos2.png) repeat-y; width:14px; height:284px;">
			</td>
		<td style="background:url(img/img_ami/amigos3.png) repeat-y; width:1035px; height:284px;" valign="top">
 <!-- inicio codigo-->
			<style type="text/css">
				.puntero{
 				Cursor : pointer;
				}
			</style>
			<script>
				function mouse_arriba(elemento){
					var trElemnto=document.getElementById(elemento);
					elemento.style.color="#FFee88";
				}
				
				function mouse_fuera(elemento,color){
					var trElemnto=document.getElementById(elemento);
					elemento.style.color=color;
				}
			</script>

			<table align="center" cellpadding="0" cellspacing="0">
				<tr align="center" style="color:#ffffff" >
    				<td colspan="2">&ensp;Torneos Amigos&ensp;</td>
   				</tr>
  			  	<tr>
    				<td colspan="2">&nbsp;</td>
    			</tr>
                <tr>
			<?php
			$sql_torneo_cons="SELECT * FROM t_tor_amigo  WHERE ESTADO=1";
			$query_torneo_cons=mysql_query($sql_torneo_cons, $conn);
	
			$i=0;
			$total=0;
			while($fila_torneo_con=mysql_fetch_assoc($query_torneo_cons)){
				if($i==0){
					$style=' style="color:#eefeee;"';
					$color="#eefeee";
					$i=1;
				}
				else{
						$style=' style="color:#FFFFFF;"';
						$color="#FFFFFF";
						$i=0;
				}
				
				
				if($total < 4){
				echo '
					<td>
						<table>    
    						<tr '.$style.' class="puntero" onclick="document.location.href=\'index.php?pag=ver_amigos.php&id='.$fila_torneo_con['ID'].'\'" 			onmouseover="mouse_arriba(this);" 		onmouseout="mouse_fuera(this,\''.$color.'\');">
								<td><img src="img/images/trofeo.png"></td>
    							<td>&ensp;'.$fila_torneo_con['NOMBRE'].'&ensp;</td>
    						</tr>
						</table>
					</td>';
				}
				else{
				echo '
				</tr>
				<tr>
					<td>
						<table>    
    						<tr '.$style.' class="puntero" onclick="document.location.href=\'index.php?pag=ver_amigos.php&id='.$fila_torneo_con['ID'].'\'" onmouseover="mouse_arriba(this);" 		onmouseout="mouse_fuera(this,\''.$color.'\');">
								<td><img src="img/images/trofeo.png"></td>
    							<td>&ensp;'.$fila_torneo_con['NOMBRE'].'&ensp;</td>
    						</tr>
						</table>
					<td';
				}
	
			}
				?>
                </tr>
			</table>
		<!--fin de codigo-->


			</td>
		<td style="background:url(img/img_ami/amigos4.png) repeat-y; width:13px; height:284px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ami/amigos5.png) no-repeat; width:1062px; height:26px;">
			</td>
	</tr>
    <tr>
		<td colspan="3" style="background:url(img/img_ami/amigos6.png) no-repeat; width:1062px; height:43px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td style="background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;">  
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