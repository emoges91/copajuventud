<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$cant_tor = mysql_num_rows($consulta_torneo);

$fila_torneo = mysql_fetch_assoc($consulta_torneo);

include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila_torneo['NOMBRE'] . ' ' . $fila_torneo['YEAR']; ?> - Control diciplinario por equipo</h1>
    <hr/>
    <?php
    if ($cant_tor > 0) {

        $cadena_equi = "
                SELECT 
                if(MAX( j.NUM_JOR ) is Null,0,MAX( j.NUM_JOR )) as MAX_NUM_JOM 
                FROM t_jornadas j
                LEFT JOIN t_eventos e ON j.ID_EVE=e.ID
                WHERE 
                    j.ESTADO=4 
                    AND e.ID_TORNEO=" . $fila_torneo['ID'] . " 
                ORDER BY j.NUM_JOR ASC";
        $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
        $total_jornadas = mysql_fetch_assoc($consulta_total_jornadas);
        $fechas = $total_jornadas['MAX_NUM_JOM'];


        $sql = "
            SELECT 
                *,(eq.ID)AS ID_EQUI 
           FROM t_even_equip eeq
           LEFT JOIN t_eventos e ON eeq.ID_EVEN=e.ID
           LEFT JOIN t_equipo eq ON eeq.ID_EQUI=eq.ID
           WHERE e.ID_TORNEO=" . $fila_torneo['ID'] . " AND e.TIPO=1";
        $query = mysql_query($sql, $conn);
        $total = mysql_num_rows($query);
        $y = 0;
        while ($row = mysql_fetch_assoc($query)) {
            $partidos = 0;
             $sqlcant = "
                    SELECT 
                        if(MAX( j.NUM_JOR ) is Null,0,MAX( j.NUM_JOR )) as MAX_NUM_JOM 
                    FROM t_jornadas j
                     LEFT JOIN t_eventos e ON j.ID_EVE=e.ID
                    WHERE 
                        j.ESTADO=4 
                        AND e.ID_TORNEO=" . $fila_torneo['ID'] . "
                        OR j.ID_EQUI_CAS=" . $row['ID_EQUI'] . " 
                        OR j.ID_EQUI_VIS=" . $row['ID_EQUI'] . " 
                    ORDER BY j.NUM_JOR ASC";
            $consultacant = mysql_query($sqlcant, $conn);
            $totalpar = mysql_fetch_assoc($consultacant);
            $partidos = $totalpar['MAX_NUM_JOM'];


            $total_tar = 0;
            $datos[$y][0] = $row['NOMBRE'];
            $sqldisc = "SELECT * FROM t_est_jug_disc WHERE ID_EQUIPO = " . $row['ID_EQUI'] . " AND ID_TORNEO= " . $fila_torneo['ID'] . " ORDER BY JORNADA ASC";
            $querydisc = mysql_query($sqldisc, $conn);
            for ($x = 1; $x < $partidos + 1; $x++) {
                $datos[$y][$x] = 0;
            }
            while ($canttar = mysql_fetch_assoc($querydisc)) {
                $x = 1;
                while (($canttar['JORNADA'] != $x) and ($canttar['JORNADA'] > $x)) {
                    $datos[$y][$x] = $datos[$y][$x];
                    $total_tar = $total_tar + 0;
                    $x++;
                }
                if (($canttar['TAR_AMA'] == 1) and ($canttar['TAR_ROJ'] == 0)) {
                    $datos[$y][$x] = $datos[$y][$x] + 1;
                    $total_tar++;
                } else {
                    if (($canttar['TAR_AMA'] == 0) and ($canttar['TAR_ROJ'] == 1)) {
                        $datos[$y][$x] = $datos[$y][$x] + 3;
                        $total_tar = $total_tar + 3;
                    } else {
                        if (($canttar['TAR_AMA'] == 1) and ($canttar['TAR_ROJ'] == 1)) {
                            $datos[$y][$x] = $datos[$y][$x] + 4;
                            $total_tar = $total_tar + 4;
                        }
                    }
                }
                $x++;
            }

            $sqldisc = "SELECT * FROM t_est_equi_disc WHERE ID_EQUIPO = " . $row['ID_EQUI'] . " AND ID_TORNEO= " . $fila_torneo['ID'] . " ORDER BY JORNADA ASC";
            $querydisc = mysql_query($sqldisc, $conn);
            while ($canttar = mysql_fetch_assoc($querydisc)) {
                $x = 1;
                while (($canttar['JORNADA'] != $x) and ($canttar['JORNADA'] > $x)) {
                    $datos[$y][$x] = $datos[$y][$x];
                    $total_tar = $total_tar + 0;
                    $x++;
                }
                $datos[$y][$x] = $datos[$y][$x] + $canttar['TAR_AMA'];
                $total_tar = $total_tar + $canttar['TAR_AMA'];
            }
            $datos[$y][$fechas + 1] = $total_tar;
            $datos[$y][$fechas + 2] = $total_tar / $fechas;
            $y++;
        }

        $g = $total - 1;

        foreach ($datos as $key => $g) {
            $totales[$key] = $g[$fechas + 2];
        }

        array_multisort($totales, SORT_ASC, $datos);

        echo '
            <table class="table1">
                    <tr id="titulo" style="color:#fff;">
                            <th>Nombre del equipo</th>';
        for ($i = 1; $i <= $fechas; $i++) {
            echo ' <th>' . $i . ' F</th>';
        }
        echo ' 
                <th> Total </th>
                <th>Prome.</th>
            </tr>';
        for ($a = 0; $a < $total; $a++) {

            echo '
		<tr id="cuerpo"><td>' . $datos[$a][0] . '</td>';
            for ($i = 1; $i <= $fechas + 1; $i++) {
                echo '
                    <td>
                        <p align="center">' . $datos[$a][$i] . '</p>
                    </td>';
            }
            echo '
                <td>
                    <p align="center">' . number_format($datos[$a][$fechas + 2], 2) . '</p>
                </td>
           </tr>';
        }
        echo'
	</table>';
    } else {
        ?>
        <h3>El torneo no ha sido posteado</h3>
        <?php
    }
    ?>
</div>
<?php
include 'inc.footer.php';
?>