<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, '1');
$nGroupsExist = $oEventos->existFaseGrupos($aEvento['ID']);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');


if (count($fila) > 0) {
    ?>
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
    <h2>Grupos</h2>
    <hr/>
    <?php
    if ($nGroupsExist > 0) {
        $cadena_equi = "
        SELECT 
        MAX(t_even_equip.NUM_GRUP) 
        FROM t_even_equip
	LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
	WHERE t_even_equip.ID_EVEN=" . $aEvento['ID'];
        $consulta_total_grupos = mysql_query($cadena_equi);
        $total_grupos = mysql_fetch_assoc($consulta_total_grupos);

        if ($total_grupos['MAX(t_even_equip.NUM_GRUP)'] > 0) {
            $cont = 1;
            for ($i = 1; $i <= $total_grupos['MAX(t_even_equip.NUM_GRUP)']; $i++) {

                $cadena_equi = "
                        SELECT 
                        *,(t_est_equi.GOL_ANO-t_est_equi.GOL_RES)as GD 
                        FROM t_even_equip
                        LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
                        LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
                        WHERE t_even_equip.ID_EVEN=" . $aEvento['ID'] . " AND t_even_equip.NUM_GRUP=" . $i . " AND t_est_equi.ID_TORNEO=" . $fila['ID'] . ' 
                        ORDER BY t_est_equi.PTS DESC,GD DESC,GOL_ANO DESC;';
                $consulta_equipos = mysql_query($cadena_equi);
                ?>

                <table class=" table_grupos table_content">
                    <tr>
                        <td style="width: 24px;">Po.</td>
                        <td>Grupo <?php echo $i; ?></td>
                        <td style="width: 24px;">PJ</td>
                        <td style="width: 24px;">PG</td>
                        <td style="width: 24px;">PE</td>
                        <td style="width: 24px;">PP</td>
                        <td style="width: 24px;">GA</td>
                        <td style="width: 24px;">GR</td>
                        <td style="width: 24px;">GD</td>
                        <td style="width: 24px;">PTS</td>
                    </tr>
                    <?php
                    $num = 1;
                    while ($fila_equi = mysql_fetch_assoc($consulta_equipos)) {
                        echo '
                            <tr>
                                <td>' . $num++ . '</td>
                                <td>' . $fila_equi['NOMBRE'] . '</td>
                                <td>' . $fila_equi['PAR_JUG'] . '</td>
                                <td>' . $fila_equi['PAR_GAN'] . '</td>
                                <td>' . $fila_equi['PAR_EMP'] . '</td>
                                <td>' . $fila_equi['PAR_PER'] . '</td>
                                <td>' . $fila_equi['GOL_ANO'] . '</td>
                                <td>' . $fila_equi['GOL_RES'] . '</td>
                                <td>' . ($fila_equi['GOL_ANO'] - $fila_equi['GOL_RES']) . '</td>
                                <td>' . $fila_equi['PTS'] . '</td>
                            </tr>';
                    }
                    ?>
                </table>
                <?php
            }
        }
    } else {
        if ($nGroupsExist == '0') {
            ?>
            <p>Las GRUPOS no han sido conformados aun, por favor siga el siguente enlace:  </p>
            <a href="torneo_grupos_crear.php?id_tor=<?php echo $sTorVerID; ?>" class="buton_css">Crear Fase Grupos</a>
            <?php
        } else {
            ?>
            <p>Este Torneo no tiene fase de grupos.  </p>
            <?php
        }
    }
} else {
    echo '<p>No existe este torneo</p>';
}
?>
<?php
include('sec/inc.footer.php');
?>