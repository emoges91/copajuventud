<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';
include 'module/equipos/jugadores.php';
include 'module/equipos/jugadores_est.php';
include 'module/equipos/equipos_est.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipos = new equipos();
$oJugadores = new jugadores();
$oJugadoresEst = new jugadores_est();
$oEquiposEst = new equipos_est();

$sJorID = (isset($_GET['jor_id'])) ? $_GET['jor_id'] : '0';
$sEventoTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '1';

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, $sEventoTipo);
$aJornadas = $oJornadas->getJornadasByID($sJorID);

$aEquipoCasa = $oEquipos->getEquiposByID($aJornadas['ID_EQUI_CAS']);
$aEquipoVisita = $oEquipos->getEquiposByID($aJornadas['ID_EQUI_VIS']);

$aJugadoresCasa = $oJugadores->getJugadoresByEquipo($sTorVerID, $aEquipoCasa['EQ_ID']);
$aJugadoresVista = $oJugadores->getJugadoresByEquipo($sTorVerID, $aEquipoVisita['EQ_ID']);
$nNumJugadoresCasa = count($aJugadoresCasa);
$nNumJugadoresVisita = count($aJugadoresVista);

$dDate = new datetime($aJornadas['FECHA']);
if($sEventoTipo=='1'){
    $destino = "document.location.href='jornadas_grupos.php';";
}
else{
    $destino = "document.location.href='llaves.php';";
}

$aEst1 = $oJugadoresEst->getInfo($aJornadas['NUM_JOR'], $sTorVerID, $aJornadas['ID_EQUI_CAS']);
$aEst2 = $oJugadoresEst->getInfo($aJornadas['NUM_JOR'], $sTorVerID, $aJornadas['ID_EQUI_VIS']);

$aEquiEst1 = $oEquiposEst->getInfo($aJornadas['NUM_JOR'], $sTorVerID, $aJornadas['ID_EQUI_CAS']);
$aEquiEst2 = $oEquiposEst->getInfo($aJornadas['NUM_JOR'], $sTorVerID, $aJornadas['ID_EQUI_VIS']);

$nEquiTarj1 = (isset($aEquiEst1[0]['TAR_AMA'])) ? $aEquiEst1[0]['TAR_AMA'] : 0;
$nEquiTarj2 = (isset($aEquiEst2[0]['TAR_AMA'])) ? $aEquiEst2[0]['TAR_AMA'] : 0;

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<h2><?php echo $aEvento['NOMBRE']; ?> - Estadisticas de la jornada </h2> 
<hr/>

<div id="marcador" class="with_info">
    <div class="marcador-header">
        <div class="jor-fecha">
            <div class="jornada" itemprop="description"><a href="/holanda/grupo1/jornada34">Jornada <?php echo $aJornadas['NUM_JOR']; ?></a></div>
            <span itemprop="startDate" class="jor-date"   > <?php echo $dDate->format('l, d F Y'); ?></span>
            <span class="jor-final abajo">FINALIZADO</span>
        </div>
    </div>
    <div class="performers" >
        <div class="equipo1"   >
            <div class="divfieldm"><img src="<?php echo $aEquipoCasa['url']; ?> " alt="<?php echo $aEquipoCasa['EQ_NOMBRE']; ?>"></div>
            <h2><?php echo $aEquipoCasa['EQ_NOMBRE']; ?></h2>
        </div>
        <div class="equipo2"  >
            <div class="divfieldm"><img src="<?php echo $aEquipoVisita['url']; ?> " alt="<?php echo $aEquipoVisita['EQ_NOMBRE']; ?>"></div>
            <h2><?php echo $aEquipoVisita['EQ_NOMBRE']; ?></h2>
        </div>
        <div class="resultado resultadoH">
            <span class="claseR" data-mid1="201418778"><?php echo $aJornadas['MAR_CASA']; ?></span>
            <span class="claseR" data-mid2="201418778"><?php echo $aJornadas['MAR_VISITA']; ?></span>
        </div>		
    </div>
    <div style="clear: both;"></div>
</div>
<br/><br/>

<form action="jornadas_est_save.php" method="post">
    <input type="hidden" name="action" value="save" />
    <input type="hidden" name="tipo" value="<?php echo $sEventoTipo; ?>" />
    <input type="hidden" name="jor_num" value="<?php echo $aJornadas['NUM_JOR']; ?>" />
    <input type="hidden" name="jor_id" value="<?php echo $aJornadas['JOR_ID']; ?>" />
    <input type="hidden" name="equi_id_1" value="<?php echo $aJornadas['ID_EQUI_CAS']; ?>" />
    <input type="hidden" name="equi_id_2" value="<?php echo $aJornadas['ID_EQUI_VIS']; ?>" />
    <input type="hidden" name="num_jug_1" value="<?php echo $nNumJugadoresCasa; ?>" />
    <input type="hidden" name="num_jug_2" value="<?php echo $nNumJugadoresVisita; ?>" />
    <table style="width: 100%;">
        <tr>
            <td style="vertical-align: top;" class="macth_table"> 
                <div class="resume_tarjetas">
                    Tarjetas Equipo: 
                    <input type="text" name="equi_tarj1" value="<?php echo $nEquiTarj1; ?>" autocomplete="off" />
                    <input type="hidden" name="equi_est_id1" value="<?php echo $aEquiEst1[0]['ID']; ?>" autocomplete="off" />
                </div>
                <br/><br/>
                <table>
                    <tr>
                        <td>Nombre</td>
                        <td>Amarilla</td>
                        <td>Roja</td>
                        <td>Goles</td>
                    </tr>
                    <tbody>
                        <?php
                        $sAma = '';
                        $sRoj = '';
                        $nGol = '0';
                        for ($nI = 0; $nI < $nNumJugadoresCasa; $nI++) {

                            $aEstJug1 = $oJugadoresEst->getJugData($aEst1, $aJugadoresCasa[$nI]['ID']);

                            $sDisable = '';
                            if ($aJugadoresCasa[$nI]['TEP_STATUS'] == '0') {
                                $sDisable = 'jug_disabled';
                            }

                            if ($aEstJug1['ama'] == '1') {
                                $sAma = 'checked';
                            }

                            if ($aEstJug1['roj'] == '1') {
                                $sRoj = 'checked';
                            }

                            $nGol = $aEstJug1['gol'];
                            if (trim($aEstJug1['gol']) == '') {
                                $nGol = 0;
                            }
                            ?>
                        <input type="hidden" name="<?php echo 'est_1_jug_' . $nI; ?>" value="<?php echo $aEstJug1['id']; ?>" autocomplete="off"  />
                        <input type="hidden" name="<?php echo 'equi_1_jug_' . $nI; ?>" value="<?php echo $aJugadoresCasa[$nI]['ID']; ?>" autocomplete="off"  />
                        <tr <?php echo 'class="' . $sDisable . '"'; ?>> 
                            <td><?php echo $aJugadoresCasa[$nI]['NOMBRE'] . ' ' . $aJugadoresCasa[$nI]['APELLIDO1'] . ' ' . $aJugadoresCasa[$nI]['APELLIDO2']; ?></td>
                            <td><input type="checkbox" value="1" name="<?php echo 'equi_1_ama_' . $nI; ?>" <?php echo $sAma; ?> autocomplete="off"  /></td>
                            <td><input type="checkbox" value="1" name="<?php echo 'equi_1_roj_' . $nI; ?>" <?php echo $sRoj; ?> autocomplete="off"  /></td>
                            <td><input type="text" size="2" value="<?php echo $nGol; ?>" name="<?php echo 'equi_1_gol_' . $nI; ?>" autocomplete="off"  /></td>
                        </tr>
                        <?php
                        $sAma = '';
                        $sRoj = '';
                        $nGol = '0';
                    }
                    ?>
                    </tbody>

                </table>

            </td>
            <td>&nbsp;</td>
            <td style="vertical-align: top;" class="macth_table"> 
                <div class="resume_tarjetas">
                    Tarjetas Equipo: 
                    <input type="text" name="equi_tarj2" value="<?php echo $nEquiTarj2; ?>" autocomplete="off" />
                    <input type="hidden" name="equi_est_id2" value="<?php echo $aEquiEst2[0]['ID']; ?>" autocomplete="off" /> 
                </div>
                <br/><br/>
                <table>
                    <tr>
                        <td>Nombre</td> 
                        <td>Amarilla</td> 
                        <td>Roja</td>  
                        <td>Goles</td>
                    </tr>
                    <tbody>
                        <?php
                        $sAma = '';
                        $sRoj = '';
                        $nGol = '0';
                        for ($nI = 0; $nI < $nNumJugadoresVisita; $nI++) {
                            $aEstJug2 = $oJugadoresEst->getJugData($aEst2, $aJugadoresVista[$nI]['ID']);
                            
                            $sDisable = '';
                            if ($aJugadoresVista[$nI]['TEP_STATUS'] == '0') {
                                $sDisable = 'jug_disabled';
                            }

                            if ($aEstJug2['ama'] == '1') {
                                $sAma = 'checked';
                            }

                            if ($aEstJug2['roj'] == '1') {
                                $sRoj = 'checked';
                            }

                            if ($aEstJug2['gol'] > 0) {
                                $nGol = $aEstJug2['gol'];
                            }
                            ?>  
                        <input type="hidden" name="<?php echo 'est_2_jug_' . $nI; ?>" value="<?php echo $aEstJug2['id']; ?>"  autocomplete="off" />
                        <input type="hidden" name="<?php echo 'equi_2_jug_' . $nI; ?>" value="<?php echo $aJugadoresVista[$nI]['ID']; ?>"  autocomplete="off" />
                        <tr <?php echo 'class="' . $sDisable . '"'; ?>> 
                            <td><?php echo $aJugadoresVista[$nI]['NOMBRE'] . ' ' . $aJugadoresVista[$nI]['APELLIDO1'] . ' ' . $aJugadoresVista[$nI]['APELLIDO2']; ?></td> 
                            <td><input type="checkbox" value="1" name="<?php echo 'equi_2_ama_' . $nI; ?>" <?php echo $sAma; ?> autocomplete="off" /></td>
                            <td><input type="checkbox" value="1" name="<?php echo 'equi_2_roj_' . $nI; ?>" <?php echo $sRoj; ?> autocomplete="off" /></td>
                            <td><input type="text" size="2" value="<?php echo $nGol; ?>" name="<?php echo 'equi_2_gol_' . $nI; ?>"  autocomplete="off" /></td> 
                        </tr>
                        <?php
                        $sAma = '';
                        $sRoj = '';
                        $nGol = '0';
                    }
                    ?>
                    </tbody>

                </table>
            </td>
        </tr>
    </table>
    <br/>
    <input type="submit" value="Guardar" class="buton_css" />
    <input type="button" value="Cancelar" onClick="<?php echo $destino; ?>" class="buton_css"/>
</form>

<?php
include('sec/inc.footer.php');
?>
