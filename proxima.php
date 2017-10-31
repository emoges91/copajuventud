<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

$sql_torneo = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($sql_torneo, $conn);
$fila_torneo = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

if ($cant_tor > 0) {

    $sql_jornada = "
            SELECT 
                j.`ID`, 
                j.`ID_EQUI_CAS`, 
                j.`ID_EQUI_VIS`, 
                j.`FECHA`, 
                j.`ESTADO`, 
                j.`NUM_JOR`, 
                j.`ID_EVE`, 
                j.`GRUPO`, 
                IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                pj.CANCHA,
                pj.HORA,
                ev.ID as ID_EVENTO,
                ev.NOMBRE as NOM_EVE,
                t.NOMBRE
            FROM t_jornadas j
        LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
        LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
        LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
        RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
        RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
        WHERE 
        t.ID=" . $sTorneoID . "
        AND j.ESTADO =2
        ORDER BY ev.ID,j.`NUM_JOR`,j.`GRUPO`,j.`ID`
        ";
    $consulta_jornada = mysql_query($sql_jornada, $conn);
    $cant_jornada = mysql_num_rows($consulta_jornada);


    include 'inc.menu_tor.php';
    ?>
    <div class="container ">
        <h1><?php echo $fila_torneo['NOMBRE'] . ' ' . $fila_torneo['YEAR']; ?> - Proxima jornada</h1>
        <hr/>

        <?php
        if ($cant_jornada != 0) {
            $nEve = '0';
            $nJor = '0';
            while ($fila_jornada = mysql_fetch_assoc($consulta_jornada)) {
                $dFechaPartido = '';
                if ($fila_jornada['FECHA'] != '') {
                    $dFechaPartido = cambiaf_a_normal($fila_jornada['FECHA']);
                }

                if ($nJor != $fila_jornada['NUM_JOR'] && $nJor != '0') {
                    echo ' </table>';
                }

                if ($nEve != $fila_jornada['ID_EVENTO']) {
                    echo "<h3>" . $fila_jornada['NOM_EVE'] . "</h3>";
                }
                if ($nJor != $fila_jornada['NUM_JOR']) {
                    echo "
                    <table class='table1'>    
                    <tr >
                        <th colspan='4'>Jornada " . $fila_jornada['NUM_JOR'] . "</th>
                        <th></th>
                    </tr>";
                }
                ?>
                <tr>
                    <td class="">
                        <span class="fecha"> <?php echo $dFechaPartido; ?></span>
                    </td>
                    <td>
                        <?php echo $fila_jornada['NOM_CASA']; ?>
                    </td>
                    <td class="">
                        <span class="hora"> <?php echo $fila_jornada['HORA']; ?></span>
                    </td>
                    <td>
                        <?php echo $fila_jornada['NOM_VISITA']; ?>
                    </td>
                    <td>
                        <p> Cancha: <?php echo $fila_jornada['CANCHA']; ?></p>
                    </td>
                    
                </tr>
                <?php
                
                if ($nJor != $fila_jornada['NUM_JOR']) {
                    $nJor = $fila_jornada['NUM_JOR'];
                }


                if ($nEve != $fila_jornada['ID_EVENTO']) {
                    $nEve = $fila_jornada['ID_EVENTO'];
                }
            }
            echo ' </table>';
        } else {
            ?>
            <h3>No se han encontrado jornadas realizadas</h3>
            <?php
        }
    } else {
        ?>
        <h3>No se han encontrado jornadas realizadas</h3>
        <?php
    }
    ?>

</div>

<?php
include 'inc.footer.php';
?>