<?php
include('conexiones/conec_cookies.php');

$sql = "SELECT * FROM t_personas WHERE ID = '" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn) or die(mysql_error());

$sql_est = "
    SELECT 
        *,
        (t_torneo.NOMBRE)as NOM_TOR,
        (t_equipo.NOMBRE)as NOM_EQUI,
        (t_torneo.ID) as IDT, 
        (t_equipo.ID) as IDE 
    FROM t_est_jug_disc ejd 
    LEFT JOIN t_equipo ON ejd.ID_EQUI = t_equipo.ID
    LEFT JOIN t_torneo ON ejd.ID_TORNEO = t_torneo.ID
    WHERE ejd.ID_PERSONA = " . $_GET['id'] . "
    ORDER BY ejd.ID ASC";
$query_est = mysql_query($sql_est, $conn) or die(mysql_error());
?>
<table width="100%" border="0" bgcolor="darkgray">
    <tr>
        <td>
            <a href="index.php">Pagina principal</a>
            ||  <a href="ver_equipo.php?id=<?php echo $_GET['idequi']; ?>">Perfil Equipo</a>
            ||  <a href="estad_juadores_direc.php?id=<?php echo $_GET['id']; ?>&idequi=<?php echo $_GET['idequi']; ?>">Perfil jugador</a>
        </td>
    </tr>
</table>
<?php
if ($fila = mysql_fetch_assoc($query)) {
    ?>
    <table width="100%">
        <tr>
            <td colspan="4"><?php echo $fila['NOMBRE'] . " " . $fila['APELLIDO1'] . " " . $fila['APELLIDO2']; ?></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td align="center">Torneo</td>
            <td align="center">Equipo</td>
            <td align="center">Tarjetas Amarillas</td>
            <td align="center">Tarjetas Rojas</td>
            <td align="center">Goles</td>
            <td align="center">Premio</td>
        </tr>
        <?php
        while ($fila_est = mysql_fetch_assoc($query_est)) {
            $tar_ama = 0;
            $tar_roj = 0;
            $sql1 = "SELECT * FROM t_est_jug_disc WHERE ID_JUGADOR=" . $_GET['id'] . " AND ID_TORNEO=" . $fila_est['IDT'] . " AND ID_EQUIPO=" . $fila_est['IDE'] . "";
            $query1 = mysql_query($sql1, $conn) or die(mysql_error());
            while ($row = mysql_fetch_assoc($query1)) {
                if (($row['TAR_AMA'] != 0) and ($row['TAR_AMA'] != NULL)) {
                    $tar_ama = $tar_ama + 1;
                }
                if (($row['TAR_ROJ'] != 0) and ($row['TAR_ROJ'] != NULL)) {
                    $tar_roj = $tar_roj + 1;
                }
            }
            echo'
	<tr align="center">
		<td align="center">' . $fila_est['NOM_TOR'] . ' ' . $fila_est['YEAR'] . '</td>
		<td align="center">' . $fila_est['NOM_EQUI'] . '</td>
		<td>' . $tar_ama . '</td>
		<td>' . $tar_roj . '</td>
		<td align="center">' . $fila_est['GOLANO'] . '</td>
		<td align="center">';
            $str_premio = "";
            if ($fila_est['PR_GOL']) {
                $str_premio = "Si";
            } else {
                $str_premio = " - ";
            }
            echo $str_premio . '
		</td>
	</tr>';
        }
        ?>    
    </table>
        <?php
    } else {
        echo '
	<table width="100%" border="0" bgcolor="darkgray">
		<tr>
			<td>No se encontran registros del jugador</td>
    	</tr>
	</table>';
    }
    ?>