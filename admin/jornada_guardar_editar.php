<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/app/app_utils.php';

$sMarCasaViejo = (isset($_POST['hdn_marcadorCasa_viejo'])) ? $_POST['hdn_marcadorCasa_viejo'] : '';
$sMarVisitaViejo = (isset($_POST['hdn_marcadorVisita_viejo'])) ? $_POST['hdn_marcadorVisita_viejo'] : '';
$sJorID = (isset($_POST['hdn_id'])) ? $_POST['hdn_id'] : '';
$sEstadoJor = (isset($_POST['hdn_estado'])) ? $_POST['hdn_estado'] : '';
$sEventoTipo = (isset($_POST['hdn_tipo'])) ? $_POST['hdn_tipo'] : '';
$sEquiCasaID = (isset($_POST['hdn_id_casa'])) ? $_POST['hdn_id_casa'] : '';
$sEquiVisitaID = (isset($_POST['hdn_id_vis'])) ? $_POST['hdn_id_vis'] : '';
$sMarCasaNuevo = (isset($_POST['TXT_marcadorCasa_nuevo'])) ? $_POST['TXT_marcadorCasa_nuevo'] : '';
$sMarVisitaNuevo = (isset($_POST['TXT_marcadorVisita_nuevo'])) ? $_POST['TXT_marcadorVisita_nuevo'] : '';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();



$flag = 0;
if (app_utils::isNumPositivo($sMarCasaNuevo) == '0' || app_utils::isNumPositivo($sMarVisitaNuevo) == '0') {
    $flag = 1;
}


//condicion para guardar
if (($flag == 0) && ($sEstadoJor == 3 || $sEstadoJor == 4 || $sEstadoJor == 5)) {

    $anterior_Njugado = 0;

    if (trim($sMarCasaNuevo) == '') {
        $sMarCasaNuevo = 'NULL';
    }
    if (trim($sMarVisitaNuevo) == '') {
        $sMarVisitaNuevo = 'NULL';
    }

    //asignar nulos si el marcador viejo es nulo 
    if (trim($sMarCasaViejo) == '-') {
        $sMarCasaViejo = 0;
        $anterior_Njugado = 1;
    }
    if (trim($sMarVisitaViejo) == '-') {
        $sMarVisitaViejo = 0;
        $anterior_Njugado = 1;
    }

    //guardar resultado
    $str_consulta = "
            UPDATE t_jornadas 
            SET 
                MARCADOR_CASA=" . $sMarCasaNuevo . ",
                MARCADOR_VISITA=" . $sMarVisitaNuevo . "
            WHERE ID=" . $sJorID;

    $equi_1_pg_n = 0;
    $equi_1_pe_n = 0;
    $equi_1_pp_n = 0;
    $equi_1_pts_n = 0;
    $equi_2_pg_n = 0;
    $equi_2_pe_n = 0;
    $equi_2_pp_n = 0;
    $equi_2_pts_n = 0;

    //descubrir ganador nuevo
    $nMarNuevoResult = ($sMarCasaNuevo) - ($sMarVisitaNuevo);
    if ($nMarNuevoResult > 0) {
        $equi_1_pg_n = 1;
        $equi_2_pp_n = 1;
        $equi_1_pp_n = 0;
        $equi_2_pg_n = 0;
        $equi_1_pe_n = 0;
        $equi_2_pe_n = 0;
        $equi_1_pts_n = 3;
        $equi_2_pts_n = 0;
    } else if ($nMarNuevoResult == 0) {
        $equi_1_pg_n = 0;
        $equi_2_pp_n = 0;
        $equi_1_pe_n = 1;
        $equi_2_pe_n = 1;
        $equi_1_pp_n = 0;
        $equi_2_pg_n = 0;
        $equi_1_pts_n = 1;
        $equi_2_pts_n = 1;
    } else {
        $equi_1_pp_n = 1;
        $equi_2_pg_n = 1;
        $equi_1_pg_n = 0;
        $equi_2_pp_n = 0;
        $equi_1_pe_n = 0;
        $equi_2_pe_n = 0;
        $equi_1_pts_n = 0;
        $equi_2_pts_n = 3;
    }

    $equi_1_pg_v = 0;
    $equi_1_pe_v = 0;
    $equi_1_pp_v = 0;
    $equi_1_pts_v = 0;
    $equi_2_pg_v = 0;
    $equi_2_pe_v = 0;
    $equi_2_pp_v = 0;
    $equi_2_pts_v = 0;

    if ($anterior_Njugado == 0) { //validar que el partido en realidad se jugo
        //descubrir ganador viejo
        $nMarViejoResult = ($sMarCasaViejo) - ($sMarVisitaViejo);
        if ($nMarViejoResult > 0) {
            $equi_1_pg_v = 1;
            $equi_2_pp_v = 1;
            $equi_1_pp_v = 0;
            $equi_2_pg_v = 0;
            $equi_1_pe_v = 0;
            $equi_2_pe_v = 0;
            $equi_1_pts_v = 3;
            $equi_2_pts_v = 0;
        } else if ($nMarViejoResult == 0) {
            $equi_1_pg_v = 0;
            $equi_2_pp_v = 0;
            $equi_1_pe_v = 1;
            $equi_2_pe_v = 1;
            $equi_1_pp_v = 0;
            $equi_2_pg_v = 0;
            $equi_1_pts_v = 1;
            $equi_2_pts_v = 1;
        } else {
            $equi_1_pp_v = 1;
            $equi_2_pg_v = 1;
            $equi_1_pg_v = 0;
            $equi_2_pp_v = 0;
            $equi_1_pe_v = 0;
            $equi_2_pe_v = 0;
            $equi_1_pts_v = 0;
            $equi_2_pts_v = 3;
        }
    }

    if (trim($sMarCasaNuevo) == 'NULL') {
        $sMarCasaNuevo = 0;
    }
    if (trim($sMarVisitaNuevo) == 'NULL') {
        $sMarVisitaNuevo = 0;
    }

    if ($anterior_Njugado == 0) {
        //quitar los datos viejos	
        $str_consulta_equi_1_v = "UPDATE t_est_equi SET ";
        //consulta solo para jornadas normales
        if (($sEventoTipo == 1)) {
            $str_consulta_equi_1_v = $str_consulta_equi_1_v . "PAR_JUG=PAR_JUG-1,
					PAR_GAN=PAR_GAN-" . $equi_1_pg_v . ",
					PAR_EMP=PAR_EMP-" . $equi_1_pe_v . ",
					PAR_PER=PAR_PER-" . $equi_1_pp_v . ",
					GOL_ANO=GOL_ANO-" . $sMarCasaViejo . ",
					GOL_RES=GOL_RES-" . $sMarVisitaViejo . ",
					PTS=PTS-" . $equi_1_pts_v . ",";
        }

        $str_consulta_equi_1_v = $str_consulta_equi_1_v . "PAR_JUG_ACU=PAR_JUG_ACU-1,
					PAR_GAN_ACU=PAR_GAN_ACU-" . $equi_1_pg_v . ",
					PAR_EMP_ACU=PAR_EMP_ACU-" . $equi_1_pe_v . ",
					PAR_PER_ACU=PAR_PER_ACU-" . $equi_1_pp_v . ",
					GOL_ANO_ACU=GOL_ANO_ACU-" . $sMarCasaViejo . ",
					GOL_RES_ACU=GOL_RES_ACU-" . $sMarVisitaViejo . ",
					PTS_ACU=PTS_ACU-" . $equi_1_pts_v . "
					WHERE ID_EQUI=" . $sEquiCasaID;

        $str_consulta_equi_2_v = "UPDATE t_est_equi SET ";
        //consulta solo para jornadas normales
        if (($sEventoTipo == 1)) {
            $str_consulta_equi_2_v = $str_consulta_equi_2_v . "PAR_JUG=PAR_JUG-1,
					PAR_GAN=PAR_GAN-" . $equi_2_pg_v . ",
					PAR_EMP=PAR_EMP-" . $equi_2_pe_v . ",
					PAR_PER=PAR_PER-" . $equi_2_pp_v . ",
					GOL_ANO=GOL_ANO-" . $sMarVisitaViejo . ",
					GOL_RES=GOL_RES-" . $sMarCasaViejo . ",
					PTS=PTS-" . $equi_2_pts_v . ",";
        }
        $str_consulta_equi_2_v = $str_consulta_equi_2_v . "PAR_JUG_ACU=PAR_JUG_ACU-1,
					PAR_GAN_ACU=PAR_GAN_ACU-" . $equi_2_pg_v . ",
					PAR_EMP_ACU=PAR_EMP_ACU-" . $equi_2_pe_v . ",
					PAR_PER_ACU=PAR_PER_ACU-" . $equi_2_pp_v . ",
					GOL_ANO_ACU=GOL_ANO_ACU-" . $sMarVisitaViejo . ",
					GOL_RES_ACU=GOL_RES_ACU-" . $sMarCasaViejo . ",
					PTS_ACU=PTS_ACU-" . $equi_2_pts_v . "
				WHERE ID_EQUI=" . $sEquiVisitaID;

        $consulta_equi_1_v = mysql_query($str_consulta_equi_1_v, $conn);
        $consulta_equi_1_v = mysql_query($str_consulta_equi_2_v, $conn);
    }

    //guardar los datos nuevos
    $sSqlEqui1 = "UPDATE t_est_equi SET ";
    //consulta solo para jornadas normales
    if (($sEventoTipo == 1)) {
        $sSqlEqui1 = $sSqlEqui1 . "PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+" . $equi_1_pg_n . ",
				PAR_EMP=PAR_EMP+" . $equi_1_pe_n . ",
				PAR_PER=PAR_PER+" . $equi_1_pp_n . ",
				GOL_ANO=GOL_ANO+" . $sMarCasaNuevo . ",
				GOL_RES=GOL_RES+" . $sMarVisitaNuevo . ",
				PTS=PTS+" . $equi_1_pts_n . ",";
    }
    $sSqlEqui1 = $sSqlEqui1 . "PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+" . $equi_1_pg_n . ",
				PAR_EMP_ACU=PAR_EMP_ACU+" . $equi_1_pe_n . ",
				PAR_PER_ACU=PAR_PER_ACU+" . $equi_1_pp_n . ",
				GOL_ANO_ACU=GOL_ANO_ACU+" . $sMarCasaNuevo . ",
				GOL_RES_ACU=GOL_RES_ACU+" . $sMarVisitaNuevo . ",
				PTS_ACU=PTS_ACU+" . $equi_1_pts_n . "
			WHERE ID_EQUI=" . $sEquiCasaID;


    $sSqlEqui2 = "UPDATE t_est_equi SET ";
    //consulta solo para jornadas normales
    if (($sEventoTipo == 1)) {
        $sSqlEqui2 = $sSqlEqui2 . "PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+" . $equi_2_pg_n . ",
				PAR_EMP=PAR_EMP+" . $equi_2_pe_n . ",
				PAR_PER=PAR_PER+" . $equi_2_pp_n . ",
				GOL_ANO=GOL_ANO+" . $sMarVisitaNuevo . ",
				GOL_RES=GOL_RES+" . $sMarCasaNuevo . ",
				PTS=PTS+" . $equi_2_pts_n . ",";
    }
    $sSqlEqui2 = $sSqlEqui2 . "PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+" . $equi_2_pg_n . ",
				PAR_EMP_ACU=PAR_EMP_ACU+" . $equi_2_pe_n . ",
				PAR_PER_ACU=PAR_PER_ACU+" . $equi_2_pp_n . ",
				GOL_ANO_ACU=GOL_ANO_ACU+" . $sMarVisitaNuevo . ",
				GOL_RES_ACU=GOL_RES_ACU+" . $sMarCasaNuevo . ",
				PTS_ACU=PTS_ACU+" . $equi_2_pts_n . "
			WHERE ID_EQUI=" . $sEquiVisitaID;


    $oQuery1 = mysql_query($sSqlEqui1, $conn);
    $oQuery2 = mysql_query($sSqlEqui2, $conn);

    //actualizar estado a anterrior con el string de arriba
    $consulta = mysql_query($str_consulta, $conn);



    if (($sEventoTipo == 1)) {
        echo "
		<script type=\"text/javascript\">
			alert('Jornadas registradas correctamente');
			document.location.href='jornadas_grupos.php';
		</script>";
    } else if ($sEventoTipo == 2) {
        echo "
		<script type=\"text/javascript\">
			alert('Jornadas registradas correctamente');
			document.location.href='llaves.php';
		</script>";
    }
} else {
    echo "
	<script type=\"text/javascript\">
		alert('Los cuadros de texto donde se digitan los marcadores deben ser numeros enteros');
		history.go(-1);
	</script>";
}
?>
