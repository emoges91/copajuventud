<?php
include('conexiones/conec_cookies.php');

$sql = "SELECT * FROM t_personas WHERE ID = '" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn) or die(mysql_error());

$sql_est = "
    SELECT 
        *,
        (t_torneo.NOMBRE)as NOM_TOR,
        (t_equipo.NOMBRE)as NOM_EQUI 
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
            ||  <a href="estad_juadores.php?id=<?php echo $_GET['id']; ?>&idequi=<?php echo $_GET['idequi']; ?>">Perfil jugador</a>
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
            <td align="center">Goles</td>
            <td align="center">Premio</td>
        </tr>
        <?php
        while ($fila_est = mysql_fetch_assoc($query_est)) {
            echo'
	<tr>
		<td align="center">' . $fila_est['NOM_TOR'] . ' ' . $fila_est['YEAR'] . '</td>
		<td align="center">' . $fila_est['NOM_EQUI'] . '</td>
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