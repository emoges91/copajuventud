<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';
include 'module/app/app_utils.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipos = new equipos();
$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, '1');
$nCantGrupos = $oEventos->totalGrupos($aEvento['ID']);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>


<script language="javascript" type="text/javascript">
    function invertir(equipoCasa1, equipoVisita2, numGrup, mitJor, jorAct) {

        var equipo1;
        var equipo2;
        var otraJorna;
        if (jorAct <= mitJor) {
            equipo1 = "i_" + numGrup + "_" + equipoCasa1 + "_" + jorAct;
            equipo2 = "i_" + numGrup + "_" + equipoVisita2 + "_" + jorAct;
            otraJorna = jorAct + mitJor;
            vuelta_ida1 = "v_" + numGrup + "_" + equipoVisita2 + "_" + otraJorna;
            vuelta_ida2 = "v_" + numGrup + "_" + equipoCasa1 + "_" + otraJorna;
        }
        else {
            equipo1 = "v_" + numGrup + "_" + equipoCasa1 + "_" + jorAct;
            equipo2 = "v_" + numGrup + "_" + equipoVisita2 + "_" + jorAct;
            otraJorna = jorAct - mitJor;
            vuelta_ida1 = "i_" + numGrup + "_" + equipoVisita2 + "_" + otraJorna;
            vuelta_ida2 = "i_" + numGrup + "_" + equipoCasa1 + "_" + otraJorna;
        }

        var equipo_selecionado1 = document.getElementById(equipo1);
        var equipo_selecionado2 = document.getElementById(equipo2);
        var equipo_afectado1 = document.getElementById(vuelta_ida1);
        var equipo_afectado2 = document.getElementById(vuelta_ida2);

        var dato1 = equipo_selecionado1.childNodes[0].nodeValue;
        var dato2 = equipo_selecionado2.childNodes[0].nodeValue;
        var dato3 = equipo_afectado1.childNodes[0].nodeValue;
        var dato4 = equipo_afectado2.childNodes[0].nodeValue;

        equipo_selecionado1.childNodes[0].nodeValue = dato2;
        equipo_selecionado2.childNodes[0].nodeValue = dato1;
        equipo_afectado1.childNodes[0].nodeValue = dato4;
        equipo_afectado2.childNodes[0].nodeValue = dato3;

        var selecionado = document.getElementById(equipo1 + "_hdn");
        var selecionado2 = document.getElementById(equipo2 + "_hdn");
        var vuelta = document.getElementById(vuelta_ida1 + "_hdn");
        var vuelta2 = document.getElementById(vuelta_ida2 + "_hdn");

        var p1 = "";
        var p2 = "";
        var u1 = "";
        var u2 = "";

        p1 = selecionado.value
        p2 = selecionado2.value;

        selecionado.value = p2;
        selecionado2.value = p1;

        u1 = vuelta.value;
        u2 = vuelta2.value;

        vuelta.value = u2;
        vuelta2.value = u1;

        alert("Jornadas volteadas");
    }
</script>


<?php
$aMatrizEquipos = array();
$aEquiposRevisar = array();

if (count($fila) > 0) {
    ?>
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
    <h2>Grupos</h2>
    <form action="jornadas_guardar_grupos.php" enctype="multipart/form-data" method="post">
        <input type="hidden" value="<?php echo $aEvento['ID']; ?>" name="id_evento">
        <div ><input class="buton_css" type="submit"  value="Guardar"></div>
        <hr>
        <?php
        for ($nGrupo = 1; $nGrupo <= $nCantGrupos; $nGrupo++) {
            $aEquiposByGrupo = $oEquipos->getEquiposByGrupo($aEvento['ID'], $nGrupo);
            ?>
            <div class="jor_box">
                <table style="width: 100%;">
                    <tr class="tr_backgroung1">
                        <td colspan="5">Grupo <?php echo $nGrupo; ?></td>
                    </tr>
                    <?php
                    //aqui comienza el ordenamiento de los partidos y jornadas
                    $nNumEquiByGrupo = count($aEquiposByGrupo);

                    if (app_utils::isPar($nNumEquiByGrupo) == 0) {
                        $nNumEquiByGrupo = $nNumEquiByGrupo + 1;
                        $aEquiposByGrupo[$nNumEquiByGrupo - 1]['ID'] = "0";
                        $aEquiposByGrupo[$nNumEquiByGrupo - 1]['NOMBRE'] = "LIBRE";
                    }

                    $nTotalJornadas = ($nNumEquiByGrupo - 1) * 2;
                    $nMitadJor = $nTotalJornadas / 2;
                    $nMitadEqui = $nNumEquiByGrupo / 2;
                    $x2 = $nMitadEqui;

                    for ($nJor = 1; $nJor <= $nTotalJornadas; $nJor++) {
                        //-----en blanco----
                        for ($o = 0; $o <= $nNumEquiByGrupo; $o++) {
                            $aEquiposRevisar[$o] = 0;
                        }
                        $aEquiposRevisar[$nNumEquiByGrupo + 1] = 1;
                        $aEquiposRevisar[0] = 1;
                        //----------------
                        echo '
                            <tr class="tr_backgroung2">
                                <td colspan="4">Jornada ' . $nJor . '</td>
                            </tr>';
                        $x1 = 1;
                        if ($x2 < $nNumEquiByGrupo) {
                            $x2+=1;
                        } else {
                            $x2 = $x1 + 1;
                        }
                        $y2 = $x2;

                        for ($e = 1; $e <= $nMitadEqui; $e++) {
                            if ($nJor > $nMitadJor) {
                                $ids2 = 'v_' . $nGrupo . '_' . $y2 . '_' . $nJor;
                                $ids1 = 'v_' . $nGrupo . '_' . $x1 . '_' . $nJor;
                                $nombre_input = 'g_' . $nGrupo . '[]';
                                $nombre_input2 = 'h_' . $nGrupo . '[]';

                                echo '
                                    <tr>
                                        <td><input type="button" value="Voltear" onclick="invertir(' . $y2 . ',' . $x1 . ',' . $nGrupo . ',' . $nMitadJor . ',' . $nJor . ');" class="boton2"></td>
                                        <td id="' . $ids2 . '">
                                            ' . $aEquiposByGrupo[$y2 - 1]['NOMBRE'] . '
                                            <input id="' . $ids2 . '_hdn" type="hidden" value="' . $aEquiposByGrupo[$y2 - 1]['ID'] . '" name="' . $nombre_input . '">
                                            <input id="' . $ids1 . '_hdn" type="hidden" value="' . $aEquiposByGrupo[$x1 - 1]['ID'] . '" name="' . $nombre_input2 . '">
                                        </td>									
                                        <td width="40px">&ensp;vrs&ensp;</td>
                                        <td id="' . $ids1 . '">' . $aEquiposByGrupo[$x1 - 1]['NOMBRE'] . '</td>
                                    </tr>';
                                $aMatrizEquipos[$y2][$x1] = 1;
                            } else {
                                $ids2 = 'i_' . $nGrupo . '_' . $y2 . '_' . $nJor;
                                $ids1 = 'i_' . $nGrupo . '_' . $x1 . '_' . $nJor;
                                $nombre_input = 'g_' . $nGrupo . '[]';
                                $nombre_input2 = 'h_' . $nGrupo . '[]';

                                echo '
                                    <tr>
                                        <td><input type="button" value="Voltear" onclick="invertir(' . $x1 . ',' . $y2 . ',' . $nGrupo . ',' . $nMitadJor . ',' . $nJor . ');" class="boton2"></td>
                                        <td id="' . $ids1 . '">
                                            ' . $aEquiposByGrupo[$x1 - 1]['NOMBRE'] . '
                                            <input id="' . $ids1 . '_hdn" type="hidden" value="' . $aEquiposByGrupo[$x1 - 1]['ID'] . '" name="' . $nombre_input . '">
                                            <input id="' . $ids2 . '_hdn" type="hidden" value="' . $aEquiposByGrupo[$y2 - 1]['ID'] . '" name="' . $nombre_input2 . '">
                                        </td>
                                        <td width="40px">&ensp;vrs&ensp;</td>
                                        <td id="' . $ids2 . '">' . $aEquiposByGrupo[$y2 - 1]['NOMBRE'] . '</td>								
                                    </tr>';
                                $aMatrizEquipos[$x1][$y2] = 1;
                            }

                            $aEquiposRevisar[$x1] = 1;
                            $aEquiposRevisar[$y2] = 1;

                            while (@$aEquiposRevisar[$x1] == 1) {
                                $x1++;
                            }

                            while (($x1 == $y2) || (@$aEquiposRevisar[$y2] == 1) || ((@$aMatrizEquipos[$x1][$y2] == 1) && (@$aMatrizEquipos[$y2][$x1] == 1)) || ((@$aMatrizEquipos[$x1][$y2] == 1) && ($nJor <= $nMitadJor))) {
                                if (($y2 < $nNumEquiByGrupo)) {
                                    $y2++;
                                } else {
                                    $y2 = $x1 + 1;
                                }
                            }
                        }
                    }
                    //hasta aqui

                    unset($aEquiposByGrupo);
                    unset($aMatrizEquipos);
                    unset($aEquiposRevisar);
                    ?>

                </table>
                <input type="hidden" name="jornadas_grupo[]" value="<?php echo $nTotalJornadas; ?>">
            </div>
            <?php
        }
        ?>
        <input type="hidden" name="num_grupos" value="<?php echo ($nGrupo - 1); ?>">
    </form>
    <?php
} else {
    echo '<p>No existe este torneo</p>';
}

include('sec/inc.footer.php');
?>
