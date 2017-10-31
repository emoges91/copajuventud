<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$cant = mysql_num_rows($consulta_torneo);
$fila = mysql_fetch_assoc($consulta_torneo);

include 'inc.menu_tor.php';
?>

<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Tabla general</h1>
    <hr/>
    <?php
    if ($cant > 0) {

        $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=1";
        $query = mysql_query($sql, $conn);
        $cant = mysql_num_rows($query);
        $row = mysql_fetch_assoc($query);

        $cadena_equi = "
            SELECT 
                *,
                (tee.GOL_ANO_ACU-tee.GOL_RES_ACU)as GD 
            FROM t_even_equip teeq
            LEFT JOIN t_equipo e ON teeq.ID_EQUI=e.ID
            LEFT JOIN t_est_equi tee ON e.ID=tee.ID_EQUI
            WHERE 
                teeq.ID_EVEN=" . $row['ID'] . " 
                AND tee.ID_TORNEO=" . $fila['ID'] . " 
            ORDER BY 
                tee.POSICION ASC,
                tee.PTS_ACU DESC,
                GD DESC,
                GOL_ANO_ACU DESC;";
        $consulta_equipos = mysql_query($cadena_equi, $conn);
        ?>
        <table  class="table1" >
            <tr >
                <th>Po.</th>
                <th>Nombre equipos</th>
                <th>PJ</th>
                <th>PG</th>
                <th>PE</th>
                <th>PP</th>
                <th>GA</th>
                <th>GR</th>
                <th>GD</th>
                <th>PTS</th>
            </tr>
            <?php
            $num = 1;

            while ($fila_equi = mysql_fetch_assoc($consulta_equipos)) {
                echo '
                <tr  id="cuerpo">
                    <td>' . $num++ . '</td>
                    <td>' . $fila_equi['NOMBRE'] . '</td>
                    <td>' . $fila_equi['PAR_JUG_ACU'] . '</td>
                    <td>' . $fila_equi['PAR_GAN_ACU'] . '</td>
                    <td>' . $fila_equi['PAR_EMP_ACU'] . '</td>
                    <td>' . $fila_equi['PAR_PER_ACU'] . '</td>
                    <td>' . $fila_equi['GOL_ANO_ACU'] . '</td>
                    <td>' . $fila_equi['GOL_RES_ACU'] . '</td>
                    <td>' . $fila_equi['GD'] . '</td>
                    <td>' . $fila_equi['PTS_ACU'] . '</td>
                </tr>';
            }
            echo'</table>';
        } else {
            ?>
            <h3>No se encuentra registrado el torneo actual</h3>
            <?php
        }
        ?>
</div>

<?php
include 'inc.footer.php';
?>