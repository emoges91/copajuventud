<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/personas/personas.php';
include 'module/equipos/equipos.php';
include 'module/equipos/jugadores.php';

$oTorneo = new torneo();
$oEquipo = new equipos();
$oPersona = new personas();

$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEquipo = $oEquipo->getByID($nEquiID);
$aPersonas = $oPersona->getByEquipoAndTorneo($sTorVerID, $nEquiID);

$nPerCant = count($aPersonas);
$nJugadores = 0;
$nAsistentes = 0;

include('sec/inc.head.php');
include('sec/inc.menu.php');
include('sec/inc.menu_equi.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<h2>Plantilla del equipo</h2>
<hr/>

<div class="equipo_detail">
    <img class="left" src="<?php echo $aEquipo['url']; ?>" width="150px">

    <div  class="left">
        <h2><?php echo $aEquipo['EQ_NOMBRE']; ?></h2>
        <h5>
            Estado:
            <?php
            if ($aEquipo['ACTIVO'] == 1) {
                echo 'Activo';
            } else {
                echo 'No activo';
            }
            ?>
        </h5> 
        <p>Cancha oficial: <?php echo $aEquipo['CO_NOMBRE']; ?> </p>
        <p>Cancha alterna: <?php echo $aEquipo['CA_NOMBRE']; ?>  </p>
    </div>
    <div class="clear"></div>
</div>

<a class="buton_css" href="./torneo_jugador_add.php?id=<?php echo $nEquiID; ?>">Agregar</a>
<div class="clear"></div>
<hr>
<table  width="100%" class="table_content" >
    <tr >
        <td></td> 
        <td width="100px"> <b>Cedula</b> </td>
        <td> <b>Nombre</b> </td>
        <td> <b>Primer apellido</b> </td>
        <td> <b>Segundo apellido</b> </td>  
        <td style="width:24px;"> <b>Jug</b> </td>
        <td style="width:24px;"> <b>DT</b> </td>
        <td style="width:24px;">  <b>Asi</b> </td>
        <td style="width:24px;"> <b>Rep</b> </td>
        <td style="width:24px;"> <b>Sup</b> </td>
        <td style="width:24px;"></td>
    </tr>
    <?php
    $nJugadores = 0;
    $nAsistentes = 0;
    for ($nI = 0; $nI < $nPerCant; $nI++) {

        $sSql = "
            select * 
            from t_car_per 
            where 
                ID_PERSONA='" . $aPersonas[$nI]['ID'] . "'
                AND ID_TORNEO='" . $sTorVerID . "'";
        $consulta = mysql_query($sSql, $conn);

        $bJugador = '';
        $bDT = '';
        $asis = '';
        $repre = '';
        $suple = '';

        while ($aCargos = mysql_fetch_assoc($consulta)) {
            if ($aCargos['CARGO'] == 'Jugador') {
                $bJugador = 'X';
                $nJugadores = $nJugadores + 1;
            }
            if ($aCargos['CARGO'] == 'Director Tecnico') {
                $bDT = 'X';
            }
            if ($aCargos['CARGO'] == 'Asistente') {
                $asis = 'X';
                $nAsistentes = $nAsistentes + 1;
            }
            if ($aCargos['CARGO'] == 'Representante') {
                $repre = 'X';
            }
            if ($aCargos['CARGO'] == 'Suplente') {
                $suple = 'X';
            }
        }

        $sLinkEnable = '  
            <a href="torneo_jugador_disable.php?per_id=' . $aPersonas[$nI]['ID'] . '&id=' . $nEquiID . '" onclick="javascript: return sureDisable();">				
                Desactivar
            </a>';
        $sDisable = '';
        if ($aPersonas[$nI]['TEP_STATUS'] == '0') {
            $sDisable = 'jug_disabled';
            $sLinkEnable = '  
            <a href="torneo_jugador_enabled.php?per_id=' . $aPersonas[$nI]['ID'] . '&id=' . $nEquiID . '" >				
                Activar
            </a>';
        }

        echo '
            <tr class="' . $sDisable . '">
                <td>
                   ' . ($nI + 1) . '
                </td>
                <td>
                    ' . $aPersonas[$nI]['CED'] . '
                </td>
                <td>
                    ' . $aPersonas[$nI]['NOMBRE'] . '
                </td>
                <td>
                    ' . $aPersonas[$nI]['APELLIDO1'] . '
                </td>
                <td>
                    ' . $aPersonas[$nI]['APELLIDO2'] . '
                </td>  
                <td>
                    <p align="center">' . $bJugador . '</p>
                </td>
                <td>
                    <p align="center">' . $bDT . '</p>
                </td>
                <td>
                    <p align="center">' . $asis . '</p>
                </td>
                <td>
                    <p align="center">' . $repre . '</p>
                </td>
                <td>
                    <p align="center">' . $suple . '</p>
                </td>
                <td align="center">
                    ' . $sLinkEnable . '
                    ||
                    <a href="torneo_jugador_est.php?per_id=' . $aPersonas[$nI]['ID'] . '&idequi=' . $nEquiID . '&id=' . $nEquiID . '">Ver</a>
                </td>
            </tr>';
    }
    ?>
</table>
<hr width="96%" size="1" align="center">
<p align="center">Total de jugadores incritos: <b><?php echo $nJugadores; ?></b></p>
<p align="center">Total de asistentes del cuerpo tecnico incritos: <b><?php echo $nAsistentes; ?></b></p>
<?php
include('sec/inc.footer.php');
?>
