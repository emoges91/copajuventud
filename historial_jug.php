<link rel="stylesheet" href="css/tabla_estilo1.css" type="text/css" />
<style>
.hiper {
	color:#930;
	text-decoration: none;
}
</style>
<?php
include('admin/conexiones/conec.php');

function cambiaf_a_normal($fecha){
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	return $lafecha;
}

$cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
$consulta_torneo= mysql_query($cadena, $conn);
$fila=mysql_fetch_assoc($consulta_torneo);
?>
<!-- Save for Web Slices (otro2.psd) -->
<table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
		<td colspan="3" style="background:url(img/otras_img/otro_01.png) no-repeat; width:1062px; height:14px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/otras_img/otro_02.png) repeat-y; width:14px; height:284px;">
			</td>
		<td style="background:url(img/otras_img/otro_03.png) repeat-y; width:1035px; height:284px;" valign="top">
         <?php		 
		$sql = "SELECT * FROM t_personas WHERE ID = '".$_GET['id']."'";
		$query = mysql_query($sql, $conn)or die(mysql_error());
		
		$sql_est = "SELECT *,(t_torneo.NOMBRE)as NOM_TOR,(t_equipo.NOMBRE)as NOM_EQUI,(t_torneo.ID) as IDT, (t_equipo.ID) as IDE FROM t_est_jug 
						LEFT JOIN t_equipo ON t_est_jug.ID_EQUI = t_equipo.ID
						LEFT JOIN t_torneo ON t_est_jug.ID_TORNEO = t_torneo.ID
						WHERE t_est_jug.ID_PERSONA = ".$_GET['id']."
						ORDER BY t_est_jug.ID ASC";
		$query_est = mysql_query($sql_est, $conn)or die(mysql_error());
		?>
		<table width="100%" border="0">
			<tr>
				<td>
					<a class="hiper" href="index.php?pag=ver_equipo.php&id_equi=<?php echo $_GET['idequi'];?>">Perfil Equipo</a>
					||  <a class="hiper" href="index.php?pag=est_jug.php&id=<?php echo $_GET['id']; ?>&idequi=<?php echo $_GET['idequi'];?>">Perfil jugador</a>
        		</td>
    		</tr>
		</table>
		<?php
		if($fila=mysql_fetch_assoc($query)){
		?>
		<table align="center">
    		<tr>
    			<td colspan="4" align="center">
					<font face="Comic Sans MS, cursive" size="+1" color="#0066CC">
						<?php echo $fila['NOMBRE']." ".$fila['APELLIDO1']." ".$fila['APELLIDO2']; ?>
                  	</font>
              	</td>
   			</tr>
    		<tr>
    			<td colspan="4"></td>
    		</tr>
        </table>
        <table align="center" class="tabla_prin">
    		<tr id="titulo" style="color:#eee;">
    			<td align="center">&ensp;Torneo&ensp;</td>
		        <td align="center">&ensp;Equipo&ensp;</td>
                <td align="center">&ensp;Tarjetas Amarillas&ensp;</td>
                <td align="center">&ensp;Tarjetas Rojas&ensp;</td>
    		    <td align="center">&ensp;Goles&ensp;</td>
        		<td align="center">&ensp;Mejor goleador&ensp;</td>
    		</tr>
		<?php
		$indi=0;
		$clase="";
		while($fila_est=mysql_fetch_assoc($query_est)){
		$tar_ama=0;
	$tar_roj=0;
	$sql1="SELECT * FROM t_est_jug_disc WHERE ID_JUGADOR=".$_GET['id']." AND ID_TORNEO=".$fila_est['IDT']." AND ID_EQUIPO=".$fila_est['IDE']."";
	$query1=mysql_query($sql1, $conn)or die(mysql_error());
	while ($row=mysql_fetch_assoc($query1))
	{
		if (($row['TAR_AMA']!=0) and ($row['TAR_AMA']!=NULL))
		{
			$tar_ama=$tar_ama+1;	
		} 
		if (($row['TAR_ROJ']!=0) and ($row['TAR_ROJ']!=NULL))
		{
			$tar_roj=$tar_roj+1;	
		}
	}
			if($indi==0){
				$clase=' class="normal"';
				$indi=1;
			}
			else{
				$clase=' class="odd"';
				$indi=0;
			}
			echo'
			<tr '.$clase.'>
				<td align="center">&ensp;'.$fila_est['NOM_TOR'].' '.$fila_est['YEAR'].'&ensp;</td>
				<td align="center">&ensp;'.$fila_est['NOM_EQUI'].'&ensp;</td>
				<td>'.$tar_ama.'</td>
				<td>'.$tar_roj.'</td>
				<td align="center">&ensp;'.$fila_est['GOLANO'].'&ensp;</td>
				<td align="center">&ensp;';
					$str_premio="";
					if($fila_est['PR_GOL']){
						$str_premio="Si";
					}
					else{
						$str_premio=" - ";
					}
				echo $str_premio.'
				&ensp;</td>
			</tr>';
		}
		?>    
		</table>
		<?php
		}
		else{
			echo '
			<table width="100%" border="0" bgcolor="darkgray">
				<tr>
					<td>No se encontran registros del jugador</td>
    			</tr>
			</table>';
		}
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