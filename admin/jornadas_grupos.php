<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$sID = (isset($_GET['ID'])) ? $_GET['ID'] : '';
$sNomb = (isset($_GET['NOMB'])) ? $_GET['NOMB'] : '';

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, '1');
$nNumGroups = $oEventos->existFaseGrupos($aEvento['ID']);

$aJornadas = $oJornadas->getJornadasGrupos($aEvento['ID']);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');

if (count($aTorneo) > 0) {

    $sSqlSig = "
        SELECT 
        NUM_JOR FROM 
        t_jornadas
	WHERE 
            t_jornadas.ID_EVE=" . $aEvento['ID'] . ' 
            AND ESTADO=2 AND NUM_JOR=1' . ' 
        ORDER BY 
            t_jornadas.NUM_JOR ASC,t_jornadas.GRUPO ASC ';
    $oQuerySig = mysql_query($sSqlSig);
    $cant_sgt = mysql_num_rows($oQuerySig);
    ?>
    <h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
    <h2><?php echo $aEvento['NOMBRE']; ?></h2> 
    <hr>
    <?php
    $comparar_jornadas = '';
    if ($nNumGroups > 0) {
        ?>
        <div width="100%" class="right">
            <input class="buton_css" type="button" onclick="document.location.href = 'jornadas_marcador.php'" value="Ingresar Marcadores">	
            <input class="buton_css" type="button" onclick="document.location.href = 'jornadas_pendientes.php'" value="Partidos Pendientes">
        </div>
        <div class="clear"></div>
        <br/>

        <?php
        if ($cant_sgt > 0) {
            ?>
            <h3>Cambiar orden de jornada en grupo:</h3>
            <div class="divCambOrd">
                <?php
                for ($o = 1; $o <= $nNumGroups; $o++) {
                    ?>
                    <input 
                        class="buton_css"
                        name="CambiarOrdenJornadas" 
                        type="button" value="Grupo <?php echo $o; ?>"
                        onclick="document.location.href = 'jornadas_cambiar.php?ID=<?php echo $sID; ?>&NOMB=<?php echo $sNomb; ?>&NUM_GRU=<?php echo $o; ?>';"/>
                        <?php
                    }
                    ?>
            </div>
            <?php
        }
        $nCantJor = count($aJornadas);
        if ($nCantJor > 0) {
            ?>
            <table class="table_jornadas">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Equipo Casa</td>
                    <td colspan="2">Marcador</td>
                    <td>Equipo visita</td>
                    <td>Fecha</td>
                    <td>Estado</td>
                    <td>Grupo</td>
                </tr>
                <?php
                for ($nI = 0; $nI < $nCantJor; $nI++) {

                    $etiqueta = '';
                    $etiqueta = 'Jornada ' . $aJornadas[$nI]['NUM_JOR'];

                    //--------------------mostrar la jornada----------
                    if ($aJornadas[$nI]['NUM_JOR'] <> $comparar_jornadas) {
                        echo '
                        <tr>
                            <td colspan="10" class="num_jornadas" >
                            ' . $etiqueta . '
                            <a class="cancha_box right" href="jornadas_horarios.php?NUM_JOR=' . $aJornadas[$nI]['NUM_JOR'] . '&ID=' . $aJornadas[$nI]['ID'] . '&TIPO=1">
                                   Horarios <img src="./images/ico_cancha_hora.png" title="Asignar a esta jornada cancha/fecha/hora"/> 
                                </a>    
                            </td> 
                        </tr> 
                        ';
                    }
                    echo '
                    <tr>
                        <td class="jornadas_td1">
                            <a href="jornadas_est.php?jor_id=' . $aJornadas[$nI]['ID'] . '&tipo=1">Resumen</a>
                        </td>
                        <td class="jornadas_td1" >
                            <a href="jornada_editar.php?id=' . $aJornadas[$nI]['ID'] . '">Editar</a>
                        </td>
                        <td  class="jornadas_td1">
                            <a href="jornadas_voltear.php?id=' . $aJornadas[$nI]['ID'] . '" onclick="javascript: return sure_volt();">Voltear</a>
                        </td> 
                        <td class="jornadas_td2" >' . $aJornadas[$nI]['NOM_CASA'] . '</td>
                        <td  class="jornadas_td1">' . $aJornadas[$nI]['MAR_CASA'] . '</td>
                        <td  class="jornadas_td2">' . $aJornadas[$nI]['MAR_VISITA'] . '</td>
                        <td  class="jornadas_td1">' . $aJornadas[$nI]['NOM_VISITA'] . '</td>
                        <td  class="jornadas_td1">' . $aJornadas[$nI]['FECHA'] . '</td>
                        <td  class="jornadas_td2">' . $aJornadas[$nI]['TJS_NOMBRE'] . '</td>
                        <td  class="jornadas_td2">' . $aJornadas[$nI]['GRUPO'] . '</td>
                    </tr>';
                    $comparar_jornadas = $aJornadas[$nI]['NUM_JOR'];
                }
                ?>
            </table>
            <?php
        } else {
            ?>
            <p> Las jornadas/partidos no se encuentran creadas, por favor crealas en el siguente enlace: </p>
            <a href="jornadas_grupos_crear.php" class="buton_css">Crear Jornadas de Grupos</a>
            <?php
        }
    } else {
        if ($nNumGroups == '0') {
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
include('sec/inc.footer.php');
?>
