<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';


$nTorneoID = (isset($_POST['torneo_id'])) ? $_POST['torneo_id'] : '0';
$aEquipos = (isset($_POST['equipos'])) ? $_POST['equipos'] : array();

$oTorneo = new torneo();
$oEventos = new eventos();
$aTroneo = $oTorneo->getTorneoByID($nTorneoID);

$sInstancia = (isset($aTroneo['INSTANCIA'])) ? $aTroneo['INSTANCIA'] : '0';
$aEvento = $oEventos->getEvenByInstancia($nTorneoID, $sInstancia);


if ($nTorneoID != '0') {

    $nEquipos = count($aEquipos);
    for ($index = 0; $index < $nEquipos; $index++) {
        //---------------------------se establece la relacion entre los equipos y eventos-----
        $sSql = "
                INSERT INTO t_even_equip 
                (`NUM_GRUP`, `ID_EQUI`, `ID_EVEN`)
                VALUES (0," . $aEquipos[$index] . "," . $aEvento['ID'] . ")";
        $query = mysql_query($sSql);

        //-------------------------------------se crea las estadisticas de los equipos-----------
        $sql = "INSERT INTO t_est_equi 
            ( 
            `ID_EQUI`, `ID_TORNEO`, `PAR_JUG`, `PAR_GAN`, `PAR_EMP`, `PAR_PER`, `GOL_ANO`, 
            `GOL_RES`, `PTS`, `PAR_JUG_ACU`, `PAR_GAN_ACU`, `PAR_EMP_ACU`, `PAR_PER_ACU`, 
            `GOL_ANO_ACU`, `GOL_RES_ACU`, `PTS_ACU`, `POSICION`, `PR_MEN_BATIDO`, `PR_MEJ_OFEN`, 
            `PR_MAS_DISC`, `PR_CAM_RECOPA`
            )
            VALUES 
            (" . $aEquipos[$index] . "," . $nTorneoID . ",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
        $query = mysql_query($sql);
    }

    echo "<script type=\"text/javascript\">
   			alert('Los equipos han sido agregados al torneo correctamente');
			document.location.href='torneo.php';
		</script>";
} else {
    echo "<script type=\"text/javascript\">
			alert('Los campos con asterisco (*) son requeridos');
			history.go(-1);
	</script>";
}
?>