<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipo = new equipos();

$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEquipo = $oEquipo->getByID($nEquiID);
$jornadas = '';


$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $aTorneo['ID'] . "";
$query = mysql_query($sql, $conn);
while ($row = mysql_fetch_assoc($query)) {
    $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
    $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
    while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
        if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($jornadas <= $total_jornadas['NUM_JOR'])) {
            $jornadas = $total_jornadas['NUM_JOR'];
        }
    }
}

$equi = "SELECT * FROM t_equipo WHERE ID=" . $nEquiID . "";
$que = mysql_query($equi, $conn);
$equip = mysql_fetch_assoc($que);

include('sec/inc.head.php');
include('sec/inc.menu.php');
include('sec/inc.menu_equi.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<hr/>

<div class="equipo_detail">
    <img class="left" src="<?php echo $aEquipo['url']; ?>" width="150px">

    <div  class="left">
        <h2><?php echo $aEquipo['EQ_NOMBRE']; ?></h2>
        <h5>
            Estado:
            <?php
            if ($aEquipo['ACTIVO'] == 1) {
                echo 'Activo';
            } else {
                echo 'No activo';
            }
            ?>
        </h5> 
        <p>Cancha oficial: <?php echo $aEquipo['CO_NOMBRE']; ?> </p>
        <p>Cancha alterna: <?php echo $aEquipo['CA_NOMBRE']; ?>  </p>
    </div>
    <div class="clear"></div>
</div>
<br/>
<h2 > TARJETAS REGISTRADAS AL EQUIPO</h2>
<br/>
<table class="table_jornadas">
    <tr >
        <td><b>Jornada</b></td>
        <td><b>Tarjeta amarilla</b></td> 
    </tr>

    <?php
    $sql1 = "SELECT * FROM t_est_equi_disc WHERE ID_TORNEO=" . $aTorneo['ID'] . " AND ID_EQUIPO=" . $nEquiID . " ORDER BY JORNADA ASC";
    $query1 = mysql_query($sql1, $conn);
    while ($tarjetas = mysql_fetch_assoc($query1)) {
        $roj = 0;
        $roj = $tarjetas['TAR_AMA'];
        echo'
        <tr >
            <td>' . $tarjetas['JORNADA'] . '</td>
            <td>' . $roj . '</td> 
        </tr>';
    }
    ?>

</table>
<?php
include('sec/inc.footer.php');
?>