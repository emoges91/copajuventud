<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena);
$cant_tor = mysql_num_rows($consulta_torneo);
$fila = mysql_fetch_assoc($consulta_torneo);


include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Tabla grupos</h1>
    <hr/>
    <?php
    if ($cant_tor > 0) {
        $cadena_equi = "SELECT 
                                *,
                                e.NOMBRE AS E_NOM,
                                (tee.GOL_ANO-tee.GOL_RES)as GD 
                            FROM t_even_equip teeq
                            LEFT JOIN t_equipo e ON teeq.ID_EQUI=e.ID
                            LEFT JOIN t_est_equi tee ON e.ID=tee.ID_EQUI
                            LEFT JOIN t_eventos te ON teeq.ID_EVEN=te.ID
                            WHERE 
                                te.TIPO=1
                                AND te.ID_TORNEO=" . $fila['ID'] . "
                                AND tee.ID_TORNEO=" . $fila['ID'] . "
                            ORDER BY 
                                teeq.NUM_GRUP ASC,
                                tee.PTS DESC,
                                GD DESC,
                                GOL_ANO DESC;";
        $consulta_equipos = mysql_query($cadena_equi);

        //llenar con equipos
        $nGrupos = '0';
        $num = 1;
        while ($fila_equi = mysql_fetch_assoc($consulta_equipos)) {

            if ($nGrupos != $fila_equi['NUM_GRUP'] && $nGrupos != '0') {
                echo ' </table>';
            }
            if ($nGrupos != $fila_equi['NUM_GRUP']) {
                $num = 1;
                echo '
                    <table  class="table1">
                            <tr id="titulo">
                                    <th></th>
                                    <th>Grupo ' . $fila_equi['NUM_GRUP'] . '</th>
                                    <th>PJ</th>
                                    <th>PG</th>
                                    <th>PE</th>
                                    <th>PP</th>
                                    <th>GA</th>
                                    <th>GR</th>
                                    <th>GD</th>
                                    <th>PTS</th>
                            </tr>';
            }

            echo '
                <tr  id="cuerpo">
                        <td>' . $num++ . '</td>
                        <td>' . $fila_equi['E_NOM'] . '</td>
                        <td>' . $fila_equi['PAR_JUG'] . '</td>
                        <td>' . $fila_equi['PAR_GAN'] . '</td>
                        <td>' . $fila_equi['PAR_EMP'] . '</td>
                        <td>' . $fila_equi['PAR_PER'] . '</td>
                        <td>' . $fila_equi['GOL_ANO'] . '</td>
                        <td>' . $fila_equi['GOL_RES'] . '</td>
                        <td>' . ($fila_equi['GOL_ANO'] - $fila_equi['GOL_RES']) . '</td>
                        <td>' . $fila_equi['PTS'] . '</td>
                </tr>';

            if ($nGrupos != $fila_equi['NUM_GRUP']) {
                $nGrupos = $fila_equi['NUM_GRUP'];
            }
        }
        echo'                     
             </table> ';
    } else {
        ?>
        <h3>No se encuentra registrado el torneo actual</h3>
        <?php
    }
    ?>
    <p>* No se toma en cuenta el goleo individual  </p>
</div>

<?php
include 'inc.footer.php';
?>