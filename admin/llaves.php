<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEventoLlave = $oEventos->getEvenByInstancia($sTorVerID, '2');
$aEventoGrupo = $oEventos->getEvenByInstancia($sTorVerID, '1');

$nUltimaJornadaGrupos = $oJornadas->getMaxJornadasByEvento($aEventoGrupo['ID']);
$nUltimaJornadaLlaves = $oJornadas->getMaxJornadasByEvento($aEventoLlave['ID']);

$aJornadas = $oJornadas->getJornadasGrupos($aEventoLlave['ID']);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<h2>Llaves</h2>
<hr>

<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'llaves_marcador.php'" value="Ingresar Marcadores">	
    <input class="buton_css" type="button" onclick="document.location.href = 'llaves_pendientes.php'" value="Partidos Pendientes">
</div>
<div class="clear"></div>
<br/>

<?php
$cant_partidos = count($aJornadas);

if (($cant_partidos > 0) && ($aTorneo['INSTANCIA']) > 1) {
    $nJorCurrent = $nUltimaJornadaGrupos;
    ?>
    <table class="table_jornadas">
        <tr >
            <td></td>
            <td></td>
            <td></td>
            <td>Equipo Casa</td>
            <td colspan="2">Marcador</td>
            <td>Equipo visita</td> 
            <td>Fecha</td>
            <td>Estado</td>
            <td>Jornada</td>
            <td>Grupo</td>
        </tr>
        <?php
        $nFinalIndicator = 0;
        while ($nJorCurrent < $nUltimaJornadaLlaves) {

            $aJornadasCurent = $oJornadas->getJornadasByNumJor($aEventoLlave['ID'], ($nJorCurrent + 1));
            $nCatJornadasCurrent = count($aJornadasCurent);

            $sEtiqueta = '';
            if ($nCatJornadasCurrent > 2) {
                $sEtiqueta = 'Fase de ' . $nCatJornadasCurrent . 'avos de Final';
            } else if ($nCatJornadasCurrent == 2) {
                if ($nFinalIndicator < 2) {
                    $nFinalIndicator++;
                    $sEtiqueta = 'Semifinales';
                } else {
                    $sEtiqueta = 'Final y Tercer Lugar';
                }
            } else {
                $sEtiqueta = 'Final';
            }

            echo ' 
            <tr>
                <td class="num_jornadas" colspan="11" >
                    <div>
                        ' . $sEtiqueta . '  /  <span class="f_gray">Jornada ' . ($nJorCurrent + 1) . '<span>
                        <a class="cancha_box right" href="jornadas_horarios.php?NUM_JOR=' . ($nJorCurrent + 1) . '&TIPO=2">
                            Horarios  <img src="./images/ico_cancha_hora.png" title="Asignar a esta jornada cancha/fecha/hora"/>
                        </a>  
                    </div> 
                </td>
            </tr>
           ';
            for ($nI = 0; $nI < $nCatJornadasCurrent; $nI++) {
                echo '
                <tr>
                     <td class="jornadas_td1">
                            <a href="jornadas_est.php?jor_id=' . $aJornadasCurent[$nI]['ID'] . '&tipo=2">Resumen</a>
                    </td>
                    <td class="jornadas_td1"><a href="jornada_editar.php?id=' . $aJornadasCurent[$nI]['ID'] . '">Editar</a></td>
                    <td class="jornadas_td1"><a href="llaves_voltear.php?id=' . $aJornadasCurent[$nI]['ID'] . '" onclick="javascript: return sure();">Voltear</a></td>
                    <td class="jornadas_td2">' . $aJornadasCurent[$nI]['NOM_CASA'] . '</td>
                    <td class="jornadas_td1">' . $aJornadasCurent[$nI]['MAR_CASA'] . '</td>
                    <td class="jornadas_td2">' . $aJornadasCurent[$nI]['MAR_VISITA'] . '</td>
                    <td class="jornadas_td1">' . $aJornadasCurent[$nI]['NOM_VISITA'] . '</td> 
                    <td class="jornadas_td2">' . $aJornadasCurent[$nI]['FECHA'] . '</td>
                    <td class="jornadas_td1">' . $aJornadasCurent[$nI]['TJS_NOMBRE'] . '</td>
                    <td class="jornadas_td2">' . $aJornadasCurent[$nI]['NUM_JOR'] . '</td>
                    <td class="jornadas_td1">' . $aJornadasCurent[$nI]['GRUPO'] . '</td>
                </tr>';
            }
            $nJorCurrent = ($nJorCurrent + 1);
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <p>La fase de llaves no se encuentra creada aun, por favor siga el siguente enlace:  </p>
    <br/>
    <a href="llaves_crear.php" class="buton_css">Crear Fase Llaves</a>
    <?php
}
?>
<?php
include('sec/inc.footer.php');
?>