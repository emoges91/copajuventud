<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');
$sJugadorID = (isset($_GET['id']) ? $_GET['id'] : '0');
$sEquiID = (isset($_GET['id_equi']) ? $_GET['id_equi'] : '0');

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$fila = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Jugador</h1>
    <hr/>
    <?php
    $sql = "SELECT * FROM t_equipo WHERE ID = '" . $sEquiID . "'";
    $query = mysql_query($sql, $conn) or die(mysql_error());
    $fila_equi = mysql_fetch_assoc($query);


    $sql_jugador = "
        SELECT 
            *,
            (t_personas.ID)AS ID_PER,
            sum(ejd.TAR_AMA) as AMA,
            sum(ejd.TAR_ROJ) as ROJ 
            FROM t_personas
        LEFT JOIN t_est_jug ON t_personas.ID=t_est_jug.ID_PERSONA
        LEFT JOIN t_est_jug_disc ejd ON t_personas.ID=ejd.ID_JUGADOR
	WHERE t_personas.ID=" . $sJugadorID;
    $consulta_jugador = mysql_query($sql_jugador, $conn);
    $fila_jugador = mysql_fetch_assoc($consulta_jugador);
    ?>
    <a href="equipo_ver.php?tor=<?php echo $sTorneoID; ?>&id_equi=<?php echo $sEquiID; ?>">
        <h3> <?php echo $fila_equi['NOMBRE']; ?></h3>
    </a>
    <?php
    echo '	
        <table class="table1">
            <tr>
                <th ><b>&ensp;Nombre&ensp;</b></th>
                <th ><b>&ensp;Primer apellido&ensp;</b></th>
                <th ><b>&ensp;Segundo apellido&ensp;</b></th>
                <th ><b>&ensp;Tarjetas Amarillas&ensp;</b></th>
                <th ><b>&ensp;Tarjetas Rojas&ensp;</b></th>
                <th ><b>&ensp;Goles&ensp;</b></th>
            </tr>
            <tr >
                <td>' . $fila_jugador['NOMBRE'] . '</td>
                <td>' . $fila_jugador['APELLIDO1'] . '</td>
                <td>' . $fila_jugador['APELLIDO2'] . '</td>
                <td>' . $fila_jugador['AMA'] . '</td>
                <td>' . $fila_jugador['ROJ'] . '</td>
                <td>' . $fila_jugador['GOLANO'] . '</td>
            </tr>
        </table>';
    ?>

</div>
<?php
include 'inc.footer.php';
?>