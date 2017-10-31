<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';

$oTorneo = new torneo();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$nEquipos = $oTorneo->valEquiposIngresados($sTorVerID);

if ($nEquipos == '0') {
    header('Location: ./torneo_add_equipos.php?id_tor=' . $sTorVerID);
}


include('sec/inc.head.php'); 
include('sec/inc.menu.php');



if (count($fila) > 0) {
    ?>
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
    <h2>Tabla General Acumulada</h2> 
    <hr/> 
    <?php
    $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=1";
    $query = mysql_query($sql, $conn);
    $cant = mysql_num_rows($query);
    $row = mysql_fetch_assoc($query);

    $cadena_equi = "SELECT *,(t_est_equi.GOL_ANO_ACU-t_est_equi.GOL_RES_ACU)as GD FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row['ID'] . " AND t_est_equi.ID_TORNEO=" . $fila['ID'] .
            " ORDER BY t_est_equi.POSICION ASC,t_est_equi.PTS_ACU DESC,GD DESC,GOL_ANO_ACU DESC;";
    $consulta_equipos = mysql_query($cadena_equi, $conn);
    ?>
    <table class="table_content" >
        <tr >
            <td>Po.</td>
            <td>Nombre equipos</td>
            <td>PJ</td>
            <td>PG</td>
            <td>PE</td>
            <td>PP</td>
            <td>GA</td>
            <td>GR</td>
            <td>GD</td>
            <td>PTS</td>
        </tr>
        <?php
        $num = 1;
        while ($fila_equi = mysql_fetch_assoc($consulta_equipos)) {
            echo
            '<tr>
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
        ?>
    </table>
    <?php
} else {
    echo 'No  se encuentra registrado el torneo actual';
}
?>
<?php
include('sec/inc.footer.php');
?>