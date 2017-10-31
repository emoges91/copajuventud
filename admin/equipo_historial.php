<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$sSql = "SELECT * FROM t_equipo WHERE ID = '" . $_GET['id'] . "'";
$oQuery = mysql_query($sSql, $conn) or die(mysql_error());

$sSqlEst = "
    SELECT 
        *,
        (t_est_equi.GOL_ANO-t_est_equi.GOL_RES)as GD,
        (t_est_equi.GOL_ANO_ACU-t_est_equi.GOL_RES_ACU)as GD_ACU 
    FROM t_est_equi 
    LEFT JOIN t_torneo ON t_est_equi.ID_TORNEO = t_torneo.ID
    WHERE t_est_equi.ID_EQUI = " . $_GET['id'] . "
    ORDER BY t_est_equi.ID ASC";
$oQueryEst = mysql_query($sSqlEst, $conn) or die(mysql_error());

if ($aEquipo = mysql_fetch_assoc($oQuery)) {
    ?>
    <h1><?php echo $aEquipo['NOMBRE']; ?></h1>
    <hr/>
    <?php
    while ($aTorEst = mysql_fetch_assoc($oQueryEst)) {
        ?>
        <br/>
        <h2><b><?php echo $aTorEst['NOMBRE'] . ' ' . $aTorEst['YEAR']; ?></b></h2>
        <h3>Fase de grupos</h3>
        <table class="table_jornadas">
            <tr>
                <td>PJ</td>
                <td>PG</td>
                <td>PE</td>
                <td>PP</td>
                <td>GA</td>
                <td>GR</td>
                <td>GD</td>
                <td>PTS</td>
            </tr>
            <tr>
                <td><?php echo $aTorEst['PAR_JUG']; ?></td>
                <td><?php echo $aTorEst['PAR_GAN']; ?> </td>
                <td><?php echo $aTorEst['PAR_EMP']; ?> </td>
                <td><?php echo $aTorEst['PAR_PER']; ?> </td>
                <td><?php echo $aTorEst['GOL_ANO']; ?> </td>
                <td><?php echo $aTorEst['GOL_RES']; ?> </td>
                <td><?php echo $aTorEst['GD']; ?> </td>
                <td><?php echo $aTorEst['PTS']; ?> </td>
            </tr>
        </table>

        <h3>Fase de llaves</h3>
        <table class="table_jornadas">
            <tr>
                <td>PJ</td>
                <td>PG</td>
                <td>PE</td>
                <td>PP</td>
                <td>GA</td>
                <td>GR</td>
                <td>GD</td>
                <td>PTS</td>
            </tr>
            <tr>
                <td><?php echo $aTorEst['PAR_JUG_ACU']; ?></td>
                <td><?php echo $aTorEst['PAR_GAN_ACU']; ?> </td>
                <td><?php echo $aTorEst['PAR_EMP_ACU']; ?> </td>
                <td><?php echo $aTorEst['PAR_PER_ACU']; ?> </td>
                <td><?php echo $aTorEst['GOL_ANO_ACU']; ?> </td>
                <td><?php echo $aTorEst['GOL_RES_ACU']; ?> </td>
                <td><?php echo $aTorEst['GD_ACU']; ?> </td>
                <td><?php echo $aTorEst['PTS_ACU']; ?> </td>
            </tr>
        </table>

        <h3>Titulos</h3>
        <table class="table_jornadas">
            <tr>
                <td align="center">&ensp;Copa rotativa&ensp;</td>
                <td align="center">&ensp;Mejor ofensiva&ensp;</td>
                <td align="center">&ensp;Menos batido&ensp;</td>
                <td align="center">&ensp;Mas Disiplinado&ensp;</td>
            </tr>
            <tr>
                <td align="center">
                    <?php
                    $str_copa = "";
                    if ($aTorEst['POSICION'] == 1) {
                        $str_copa = "Campeon";
                    } else if ($aTorEst['POSICION'] == 2) {
                        $str_copa = "Subcampeon";
                    } else if ($aTorEst['POSICION'] == 3) {
                        $str_copa = "Tercer lugar";
                    } else if ($aTorEst['POSICION'] == 3) {
                        $str_copa = "Cuarto lugar";
                    } else {
                        $str_copa = " - ";
                    }
                    echo $str_copa;
                    ?>
                </td>
                <td align="center">
                    <?php
                    $str_m_o = "";
                    if ($aTorEst['PR_MEJ_OFEN']) {
                        $str_m_o = "Si";
                    } else {
                        $str_m_o = " - ";
                    }
                    echo $str_m_o;
                    ?>
                </td>
                <td align="center">
                    <?php
                    $str_m_b = "";
                    if ($aTorEst['PR_MEN_BATIDO']) {
                        $str_m_b = "Si";
                    } else {
                        $str_m_b = " - ";
                    }
                    echo $str_m_b;
                    ?>
                </td>
                <td align="center">
                    <?php
                    $str_m_d = "";
                    if ($aTorEst['PR_MAS_DISC']) {
                        $str_m_d = "Si";
                    } else {
                        $str_m_d = " - ";
                    }
                    echo $str_m_d;
                    ?>
                </td>
            </tr>
        </table>

        <hr/>
        <br/>
        <?php
    }
    ?>
    <?php
} else {
    ?>
    <br/><br/>
    <p>No se encontran registros del equipo</p> 
    <br/><br/>
    <?php
}

include('sec/inc.footer.php');
?>