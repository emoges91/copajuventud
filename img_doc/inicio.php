<link rel="stylesheet" href="css/style1.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js" ></script>
<script type="text/javascript" src="scripts/coin-slider.min.js"></script>
<!--<script type="text/javascript" src="scripts/jquery-1.4.2.js"></script> -->
<link rel="stylesheet" href="scripts/coin-slider-styles.css" type="text/css" /> 
<script language="javascript 1.2">
<!--
var i;
var imagenes = new Array('img/images/acordeon_r2.png','img/images/acordeon_prox2.png','img/images/acordeon2.png','img/images/acordeon_r.png','img/images/acordeon_prox.png','img/images/acordeon.png');
var lista_imagenes = new Array();
function cargarimagenes(){
for(i in imagenes){
lista_imagenes[i] = new Image();
lista_imagenes[i].src = imagenes[i];
}
}
//-->
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 10000, true);
	});
</script>
<!--
<script type="text/javascript">
	function cambiar(dt,tipo){
		if(tipo==1){
			var obj_dt=document.getElementById(dt);
			obj_dt.style.background ="url(img/images/acordeon_r2.png) no-repeat;";
			obj_dt.width="241px";
		}
		else if(tipo==2){
			var obj_dt=document.getElementById(dt);
			obj_dt.style.background ="url(img/images/acordeon_prox2.png) no-repeat;";
			obj_dt.width="241px";
			
		}
		else{
			var obj_dt=document.getElementById(dt);
			obj_dt.style.background ="url(img/images/acordeon2.png) no-repeat;";
			obj_dt.width="241px";
		}
	}
	function volver(dt,tipo){
		if(tipo==1){
			document.getElementById(dt).style.background ="url(img/images/acordeon_r.png) no-repeat;";
		}
		else if(tipo==2){
			document.getElementById(dt).style.background ="url(img/images/acordeon_prox.png) no-repeat;";
		}
		else{
			document.getElementById(dt).style.background ="url(img/images/acordeon.png) no-repeat;";
		}
	}
</script>-->
<body onLoad="cargarimagenes()" >
<!-- Save for Web Slices (inicio.psd) -->
<table id="inicio" width="1063px" height="454px" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="10" style=" background:url(img/img_ini/inicio_01.png) no-repeat; width:1062px; height:14px">
			</td>
	</tr>
	<tr >
		<td rowspan="2" style=" background:url(img/img_ini/inicio_02.png) repeat-y; width:14px; height:284px;">
            </td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_03.png) repeat-y; width:241px; height:284px;" valign="top">
        	<?php $var_estado_jornada=4;?>
            <div id="accordion">
				<dl class="accordion" id="slider">
					<dt id="resultados"  onmouseover="cambiar('resultados',1);" onMouseOut="volver('resultados',1);">Resultados</dt>
					<dd class="dd">
						<span> <?php include("fechas.php"); ?> </span>
					</dd>
					<dt id="prox_jor" onMouseOver="cambiar('prox_jor',2);" onMouseOut="volver('prox_jor',2);">Proxima Jornada</dt>
					<dd  class="dd">
                    	<?php $var_estado_jornada=2; ?>
						<span><?php include("fechas.php"); ?></span>
					</dd>
					<dt id="tabla" onMouseOver="cambiar('tabla',3);" onMouseOut="volver('tabla',3);">Tabla Grupos</dt>
					<dd class="dd">
						<span><?php include("tabla_grupos2.php"); ?></span>
					</dd>
				</dl>
			</div>
			</td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_04.png) repeat-y; width:14px; height:284px;">
			</td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_05.png) repeat-y; width:14px; height:284px;">
			</td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_06.png) repeat-y; width:14px; height:284px;">
			</td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_07.png) repeat-y; width:525px; height:284px;" valign="top">
			<?php
			include('admin/conexiones/conec.php');
			$sql2 = "SELECT * FROM t_noticias";
			$que = mysql_query($sql2, $conn);
			$row2=mysql_num_rows($que);
			if ($row2<=16){
				$limite = 0;
				$cant=$row2;
			}
			else{
				$limite = 0;
				$cant = 16;
			}
			
			$sql="SELECT * FROM t_noticias ORDER BY ID DESC LIMIT $limite,$cant";
			$query=mysql_query($sql, $conn);	
			$cont=0;
			echo '<div id="coin-slider">';
			while ($row=mysql_fetch_assoc($query)){
				echo '<a href="index.php?pag=detalle_noticia.php&id='.$row['ID'].'"> 
				<img src="admin/noticias/'.$row['URL_IMAGEN'].'" alt="'.$row['TITULO'].'" /> 
				<span> 
					<b>'.$row['TITULO'].'</b><br /> 
					'.substr($row['DESCRIPCION_CORTA'],0,150).'
				</span> 
				</a> ';
			}
			echo '</div>';
			?>
    		<br />
    		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like></fb:like>
            </td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_08.png) repeat-y; width:14px; height:284px;">
			</td>
		<td rowspan="2" style=" background:url(img/img_ini/inicio_09.png) repeat-y; width:28px; height:284px;">
			</td>
		<td colspan="2"  valign="top">
			<table cellpadding="0" cellspacing="0">
            	<tr>
                	<td style=" background:url(img/img_ini/inicio_10.png) repeat-y; width:15px; height:127px;">
                    </td>
                    <td  style=" background:url(img/img_ini/inicio_11.png) repeat-y; width:170px; height:127px;" align="left" valign="top">
                    <?php
						include("content_oficial.html");
					?>
                    </td>
                    <td  style=" background:url(img/img_ini/inicio_12.png) repeat-y; width:13px; height:127px;">
                    </td> 
                </tr>
                <tr>
                	<td colspan="3" style=" background:url(img/img_ini/inicio_13.png) no-repeat; width:198px; height:15px;">                    
                    </td>
                </tr>
                <tr>
					<td colspan="3">
					</td>
				</tr>
              </table>
 		</td>
	</tr>
	<tr>
        <td colspan="2"  valign="bottom">
    		<table cellpadding="0" cellspacing="0">
    	    	<tr valign="bottom">
					<td colspan="3"  style=" background:url(img/img_ini/inicio_15.png) no-repeat; width:198px; height:18px;">
					</td>
				</tr>
    	      	<tr>
					<td style=" background:url(img/img_ini/inicio_16.png) repeat-y; width:14px; height:110px;">
				  	</td>
    	   			<td style=" background:url(img/img_ini/inicio_17.png) repeat-y; width:171px; height:110px;"">    
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="171px" height="110px" id="new.swf" align="top">
							<param name="allowScriptAccess" value="sameDomain">
							<param name="movie" value="new.swf">
							<param name="quality" value="medium">
							<param name="bgcolor" value="#4091cc">
							<param name="salign" value="r">
							<embed src="img/new.swf" quality="medium" bgcolor="#4091cc" width="170px" height="110px" name="new.swf" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
						</object>
				  	</td>
					<td  style=" background:url(img/img_ini/inicio_18.png) repeat-y; width:13px; height:110px;"">
					</td>
				</tr>
 		   	</table>
     	</td>
	</tr>
	<tr>
		<td colspan="10" style=" background:url(img/img_ini/inicio_19.png) no-repeat; width:1062px; height:71px;">
			</td>
	</tr>
	<tr>
		<td  style=" background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td colspan="8"  style=" background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;">
        <?php
		   include('content_secundario.html');
		?>
			</td>
		<td  style=" background:url(img/img_ini/inicio_22.png) repeat-y; width:13px; height:66px;">
			</td>
	</tr>
	<tr>
		<td colspan="10"  style=" background:url(img/img_ini/inicio_23.png) no-repeat; width:1062px; height:18px;">
			</td>
	</tr>
	<tr>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="241" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="525" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="28" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="185" height="1" alt=""></td>
		<td>
			<img src="img/img_ini/espacio.gif" width="14" height="1" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
<script type="text/javascript">

var slider1=new accordion.slider("slider1");
slider1.init("slider");

var slider2=new accordion.slider("slider2");
slider2.init("slider2",0,"open");

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#coin-slider').coinslider({ width: 525, navigation: true, delay: 5000, effect: 'random' });
	});
</script>
</body>