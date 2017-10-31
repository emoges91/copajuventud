<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" />
<?php
include('../conexiones/conec_cookies.php');
$dire='../';
include_once('../mostrar_torneo.php');

//-----------------------------------grupos----------------------------------------
$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID']." and TIPO=1";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
$row=mysql_fetch_assoc($query);	

if ($cant>0){
	$cadena_equi="SELECT MAX(t_even_equip.NUM_GRUP)as MAXGRUPO FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				WHERE t_even_equip.ID_EVEN=".$row['ID'];
	$consulta_total_grupos = mysql_query($cadena_equi, $conn);
	$total_grupos=mysql_fetch_assoc($consulta_total_grupos);
?>
	<table>
		<tr>
		<?php	
		if($total_grupos['MAXGRUPO']>0){
			$cont=1;
			for($i=1;$i<=$total_grupos['MAXGRUPO'];$i++){	
				
				$cadena_equi="SELECT *,(t_est_equi.GOL_ANO-t_est_equi.GOL_RES)as GD FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=".$row['ID']." AND t_even_equip.NUM_GRUP=".$i." AND t_est_equi.ID_TORNEO=".$_GET['ID'].
				' ORDER BY t_est_equi.PTS DESC,GD DESC,GOL_ANO DESC;';
				$consulta_equipos = mysql_query($cadena_equi, $conn);
				if($cont==3){
					echo'</tr>
					<tr>';
					$cont=1;
				}
				$cont++;	
			?>
				<td valign="top" class="tabla">
                <table cellpadding="0" cellspacing="0">
                	<tr align="center">
                    	<td colspan="10" id="titulo">Grupo <?php echo $i;?></td>
                    </tr>
					<tr>
						<th>Po.</th>
						<th>Equipos</th>
						<th>PJ</th>
						<th>PG</th>
						<th>PE</th>
						<th>PP</th>
						<th>GA</th>
						<th>GR</th>
						<th>GD</th>
						<th style="border-right:1px solid #ddd;">PTS</th>
					</tr>
				<?php
				$num=1;
				while($fila_equi=mysql_fetch_assoc($consulta_equipos)){
				?>
					<tr>
							<td><?php echo $num++; ?></td>
							<td><?php echo $fila_equi['NOMBRE']; ?></td>
							<td><?php echo $fila_equi['PAR_JUG']; ?></td>
							<td><?php echo $fila_equi['PAR_GAN']; ?></td>
							<td><?php echo $fila_equi['PAR_EMP']; ?></td>
							<td><?php echo $fila_equi['PAR_PER']; ?></td>
							<td><?php echo $fila_equi['GOL_ANO']; ?></td>
							<td><?php echo $fila_equi['GOL_RES']; ?></td>
							<td><?php echo ($fila_equi['GOL_ANO']-$fila_equi['GOL_RES']); ?></td>
							<td style="border-right:1px solid #ddd;"><?php echo $fila_equi['PTS']; ?></td>
						</tr>
                <?php        
				}
				?>
				</table></td>
			<?php
            }
		}
		?>
			</tr>
		</table>
    <?php
	}
	else{
		echo 'No existe fase de grupos o sus jornadas.';
	}
?>