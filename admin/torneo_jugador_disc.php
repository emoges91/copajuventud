<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';

$oTorneo = new torneo();
$aTorneo = $oTorneo->getTorneoByID($sTorVerID);

$nTorneo = count($aTorneo);

////////////////////////////////////////////////////////////////////////////////
$nJorTotal = 0;
$sSql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $aTorneo['ID'] . "";
$oQuery = mysql_query($sSql, $conn);
while ($aEvento = mysql_fetch_assoc($oQuery)) {
    $sSqlEven = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $aEvento['ID'] . " ORDER BY NUM_JOR ASC";
    $oJorTot = mysql_query($sSqlEven, $conn);
    while ($aJorTot = mysql_fetch_assoc($oJorTot)) {
        if (($aJorTot['MARCADOR_VISITA'] != NULL) AND ($nJorTotal <= $aJorTot['NUM_JOR'])) {
            $nJorTotal = $aJorTot['NUM_JOR'];
        }
    }
}

$sSql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $aTorneo['ID'] . " AND TIPO=1";
$oQuery = mysql_query($sSql, $conn);
$aEven = mysql_fetch_assoc($oQuery);
$sSql = "
    select 
          DISTINCT  
        eq.ID as EQ_ID,
        eq.url,
        eq.NOMBRE as EQ_NOMBRE, 
        eq.ACTIVO as EQ_ACTIVO, 
        eq.CAN_OFI as EQ_OFI, 
        eq.CAN_ALT as EQ_ALT, 
        eq.url as EQ_URL,
        (co.NOMBRE) CO_NOMBRE,
        (ca.NOMBRE) CA_NOMBRE
    from t_equipo eq
    LEFT JOIN t_even_equip ee on eq.id =ee.ID_EQUI
    LEFT JOIN t_eventos e on e.id =ee.ID_EVEN
    LEFT JOIN t_cancha co ON eq.CAN_OFI=co.ID
    LEFT JOIN t_cancha ca ON eq.CAN_ALT=ca.ID
    WHERE
        e.ID_TORNEO='" . $sTorVerID . "' 
    ORDER BY 
        eq.NOMBRE ASC
    ";
$oQuery = mysql_query($sSql, $conn);


include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<h2>Disciplina de Jugadores - Jornada <?php echo $nJorTotal; ?></h2>
<hr/> 

<style type="text/css">
    #Container {
        overflow: scroll;
    }

</style>

<?php
if ($nTorneo > 0) {
    ?>
    <div id="Container">
        <?php
        while ($aEqui = mysql_fetch_assoc($oQuery)) {
            $sSqlJug = "
                    SELECT 
                        *,
                        p.ID as P_ID
                    FROM t_est_jug_disc ejd
                    LEFT JOIN t_personas p
                        ON 
                            ejd.ID_JUGADOR=p.ID
                    WHERE 
                        ejd.ID_EQUIPO = " . $aEqui['EQ_ID'] . " 
                        AND ejd.ID_TORNEO = " . $aTorneo['ID'] . " 
                        AND (ejd.TAR_AMA = 1 OR ejd.TAR_ROJ = 1)
                    ORDER BY p.ID ASC,ejd.JORNADA ASC";
            $oQueryDisc = mysql_query($sSqlJug, $conn);
            $nTarCant = mysql_num_rows($oQueryDisc);

            if ($nTarCant > 0) {
                ?>
                <br/>
                <h3><?php echo $aEqui['EQ_NOMBRE']; ?></h3>
                <table class=" ">
                    <tr align="center" >
                        <td rowspan="2" style="border:1px solid #000; vertical-align: middle;">
                            Nombre
                        </td>
                        <td colspan="<?php echo $nJorTotal; ?>" style="border:1px solid #000">
                            Jornadas
                        </td>
                        <td rowspan="2" width="45px" align="center" style="border:1px solid #000">
                            Total
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $i = 1;
                        while ($nJorTotal >= $i) {
                            ?>
                            <td width="35px" style="border:1px solid #000"><?php echo $i; ?> </td>
                            <?php
                            $i++;
                        }
                        ?>
                    </tr>   
                    <?php
                    $nPerID = '';
                    $nJugControl = 0;
                    $aAmarilla = array_fill(1, $nJorTotal, '');
                    $aRoja = array_fill(1, $nJorTotal, '');
                    $nTarAma = 0;
                    $nTarRoj = 0;
                    while ($aJug = mysql_fetch_assoc($oQueryDisc)) {

                        $nJor = $aJug['JORNADA'];

                        //////////////////////////////////////////////////////////////////////
                        if (($aJug['TAR_AMA'] == 1)) {
                            $aAmarilla[$nJor] = 'A';
                            $nTarAma++;
                        }
                        if (($aJug['TAR_ROJ'] == 1)) {
                            $aRoja[$nJor] = 'R';
                            $nTarRoj++;
                        }

                        //////////////////////////////////////////////////////////////////////
                        if ($nJugControl == 1) {
                            for ($nI = 1; $nI <= $nJorTotal; $nI++) {
                                echo'<td style="border:1px solid #000";>';
                                echo $aAmarilla[$nI];
                                echo $aRoja[$nI];
                                echo'</td>';
                            }
                            ?>
                            <td align="center" style="border:1px solid #000">

                               <div   style=" padding:0 15px; background:#F8F400 ;">
                                    <?php echo $nTarAma; ?>
                                </div> 
                                <div  style="padding:0 15px; background:#FF4D4D ;">
                                    <?php echo $nTarRoj; ?>
                                </div> 
                            </td>
                            </tr>
                            <?php
                            $nJugControl = 0;
                            $nTarAma = 0;
                            $nTarRoj = 0;
                            $aAmarilla = array_fill(1, $nJorTotal, '');
                            $aRoja = array_fill(1, $nJorTotal, '');
                        }

                        //////////////////////////////////////////////////////////////////////
                        if ($nPerID != $aJug['P_ID']) {
                            $nPerID = $aJug['P_ID'];
                            ?>
                            <tr style="border:1px solid #000;">
                                <td style="border:1px solid #000;">
                                    <?php echo $aJug['NOMBRE'] . ' ' . $aJug['APELLIDO1'] . ' ' . $aJug['APELLIDO2']; ?>
                                </td>
                                <?php
                                $nJugControl = 1;
                            }
                        }

                        //////////////////////////////////////////////////////////////////////
                        if ($nJugControl == 1) {
                            for ($nI = 1; $nI <= $nJorTotal; $nI++) {
                                echo'<td style="border:1px solid #000";>';
                                echo $aAmarilla[$nI];
                                echo $aRoja[$nI];
                                echo'</td>';
                            }
                            ?>
                            <td align="center" style="border:1px solid #000"> 
                                <div   style=" padding:0 15px; background:#F8F400 ;">
                                    <?php echo $nTarAma; ?>
                                </div> 
                                <div  style="padding:0 15px; background:#FF4D4D ;">
                                    <?php echo $nTarRoj; ?>
                                </div> 
                            </td>
                        </tr>
                        <?php
                        $nJugControl = 0;
                        $nTarAma = 0;
                        $nTarRoj = 0;
                        $aAmarilla = array_fill(1, $nJorTotal, '');
                        $aRoja = array_fill(1, $nJorTotal, '');
                    }
                    ?>
                </table>
                <br/>
                <?php
            }
        }
        ?>
    </div> 
    <?php
} else {
    echo '<p>No hay torneo registrados</p>';
}
?>

<?php
include('sec/inc.footer.php');
?>