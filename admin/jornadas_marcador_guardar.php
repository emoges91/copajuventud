<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/app/app_utils.php';
include 'module/torneos/jornadas.php';

$nTotalPartidos = (isset($_POST['total_partidos'])) ? $_POST['total_partidos'] : '';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();


$flag = 0;
$flag_chekeados = 0;
for ($i = 1; $i <= $nTotalPartidos; $i++) {
    $check_partidos = 'CHK_partidos' . $i;
    $marcadores_casa = 'TXT_marcadorCasa' . $i;
    $maradores_visita = 'TXT_marcadorVisita' . $i;
    $id_equipo = 'hdn_idPartido' . $i;

    //consulta para obtener los id de los equipos
    $str_consulta_equipos = "SELECT * FROM t_jornadas
	WHERE ID=" . $_POST[$id_equipo];
    $consulta_equipos = mysql_query($str_consulta_equipos, $conn) or die(mysql_error());
    $fila = mysql_fetch_assoc($consulta_equipos);

    $var_flag = 0;
    if (($fila['ID_EQUI_CAS'] == 0) || ($fila['ID_EQUI_VIS'] == 0)) {
        $var_flag = 1;
    }

    if (($_POST[$check_partidos] == 'on') && ($var_flag == 0)) {
        $var_marcador_casa = $_POST[$marcadores_casa];
        $var_marcador_visita = $_POST[$maradores_visita];

        $flag_chekeados = 1;

        if (app_utils::isNumPositivo($var_marcador_casa) == '0' || app_utils::isNumPositivo($var_marcador_visita) == '0') {
            $flag = 1;
        }
    }
}

if (($flag == 0) && ($flag_chekeados == 1)) {

    for ($i = 1; $i <= $nTotalPartidos; $i++) {
        $check_partidos = 'CHK_partidos' . $i;
        $marcadores_casa = 'TXT_marcadorCasa' . $i;
        $maradores_visita = 'TXT_marcadorVisita' . $i;
        $id_equipo = 'hdn_idPartido' . $i;

        //-----------si esta chekeado
        if ($_POST[$check_partidos] == 'on') {

            if ($_POST[$marcadores_casa] == '') {
                $_POST[$marcadores_casa] = 'NULL';
            }
            if ($_POST[$maradores_visita] == '') {
                $_POST[$maradores_visita] = 'NULL';
            }

            //actualizar estado a anterrior
            $str_consulta = "UPDATE t_jornadas 
                SET 
				MARCADOR_CASA=" . $_POST[$marcadores_casa] . ",
				MARCADOR_VISITA=" . $_POST[$maradores_visita] . ",
				ESTADO=4
			WHERE ID=" . $_POST[$id_equipo];


            //consulta para obtener los id de los equipos
            $str_consulta_equipos = "SELECT * FROM t_jornadas
			WHERE ID=" . $_POST[$id_equipo];
            $consulta_equipos = mysql_query($str_consulta_equipos, $conn) or die(mysql_error());
            $fila = mysql_fetch_assoc($consulta_equipos);

            $equi_1_pg = 0;
            $equi_1_pe = 0;
            $equi_1_pp = 0;
            $equi_1_pts = 0;
            $equi_2_pg = 0;
            $equi_2_pe = 0;
            $equi_2_pp = 0;
            $equi_2_pts = 0;

            $resultado = ($_POST[$marcadores_casa]) - ($_POST[$maradores_visita]);
            if ($resultado > 0) {

                $equi_1_pg = 1;
                $equi_2_pp = 1;
                $equi_1_pp = 0;
                $equi_2_pg = 0;
                $equi_1_pe = 0;
                $equi_2_pe = 0;
                $equi_1_pts = 3;
                $equi_2_pts = 0;
            } else if ($resultado == 0) {
                $equi_1_pg = 0;
                $equi_2_pp = 0;
                $equi_1_pe = 1;
                $equi_2_pe = 1;
                $equi_1_pp = 0;
                $equi_2_pg = 0;
                $equi_1_pts = 1;
                $equi_2_pts = 1;
            } else {
                $equi_1_pp = 1;
                $equi_2_pg = 1;
                $equi_1_pg = 0;
                $equi_2_pp = 0;
                $equi_1_pe = 0;
                $equi_2_pe = 0;
                $equi_1_pts = 0;
                $equi_2_pts = 3;
            }

            if (($fila['ID_EQUI_CAS'] != '0') && ($fila['ID_EQUI_VIS'] != '0')) {
                $str_consulta_equi_1 = "UPDATE t_est_equi SET 
				PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+" . $equi_1_pg . ",
				PAR_EMP=PAR_EMP+" . $equi_1_pe . ",
				PAR_PER=PAR_PER+" . $equi_1_pp . ",
				GOL_ANO=GOL_ANO+" . $_POST[$marcadores_casa] . ",
				GOL_RES=GOL_RES+" . $_POST[$maradores_visita] . ",
				PTS=PTS+" . $equi_1_pts . ",
				PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+" . $equi_1_pg . ",
				PAR_EMP_ACU=PAR_EMP_ACU+" . $equi_1_pe . ",
				PAR_PER_ACU=PAR_PER_ACU+" . $equi_1_pp . ",
				GOL_ANO_ACU=GOL_ANO_ACU+" . $_POST[$marcadores_casa] . ",
				GOL_RES_ACU=GOL_RES_ACU+" . $_POST[$maradores_visita] . ",
				PTS_ACU=PTS_ACU+" . $equi_1_pts . "
				WHERE ID_EQUI=" . $fila['ID_EQUI_CAS'];

                $str_consulta_equi_2 = "UPDATE t_est_equi SET 
				PAR_JUG=PAR_JUG+1,
				PAR_GAN=PAR_GAN+" . $equi_2_pg . ",
				PAR_EMP=PAR_EMP+" . $equi_2_pe . ",
				PAR_PER=PAR_PER+" . $equi_2_pp . ",
				GOL_ANO=GOL_ANO+" . $_POST[$maradores_visita] . ",
				GOL_RES=GOL_RES+" . $_POST[$marcadores_casa] . ",
				PTS=PTS+" . $equi_2_pts . ",
				PAR_JUG_ACU=PAR_JUG_ACU+1,
				PAR_GAN_ACU=PAR_GAN_ACU+" . $equi_2_pg . ",
				PAR_EMP_ACU=PAR_EMP_ACU+" . $equi_2_pe . ",
				PAR_PER_ACU=PAR_PER_ACU+" . $equi_2_pp . ",
				GOL_ANO_ACU=GOL_ANO_ACU+" . $_POST[$maradores_visita] . ",
				GOL_RES_ACU=GOL_RES_ACU+" . $_POST[$marcadores_casa] . ",
				PTS_ACU=PTS_ACU+" . $equi_2_pts . "
				WHERE ID_EQUI=" . $fila['ID_EQUI_VIS'];

                $consulta_equi_1 = mysql_query($str_consulta_equi_1, $conn) or die(mysql_error());
                $consulta_equi_1 = mysql_query($str_consulta_equi_2, $conn) or die(mysql_error());
            }
        } else {//si no esta chekeado
            $str_consulta = "UPDATE t_jornadas SET 
				ESTADO=1
			WHERE ID=" . $_POST[$id_equipo];
        }
        //actualizar estado a anterrior con el string de arriba
        $consulta = mysql_query($str_consulta, $conn) or die(mysql_error());
    }

    list($jornada_actual, $id_evento) = explode("/", $_POST['Hdn_jornadaActual']);

    $oJornadas->setJornadasToSiguientes($id_evento, ($jornada_actual + 1));

    //actualizar la jornada anterior
    if (($jornada_actual - 1) <> 0) {
        $oJornadas->setJornadasToJugadas($id_evento, ($jornada_actual - 1));
    }

    $nTotalJornadas = $oJornadas->getMaxJornadasByEvento($id_evento);
    $nPartPendientes = $oJornadas->getTotalJornadasPendientes($id_evento);

    //actualizar el torneo a la siguiente face
    if (($nTotalJornadas < ($jornada_actual + 1)) && ($nPartPendientes == 0)) {
        $oTorneo->sumarInstancia($sTorVerID);
    }

    echo "
        <script type=\"text/javascript\">
            alert('Marcados actualizados correctamente.');
            document.location.href='jornadas_grupos.php';
	</script>";
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Los marcadores de los partidos chekeados deben llevar numeros enteros.');
            history.go(-1);
        </script>";
}
?>
