<?php

include('conexiones/conec_cookies.php');

$nTorneoID = (isset($_GET['id'])) ? $_GET['id'] : '';

//--------------------------consulta eventos fase de llave-------------------------
$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $nTorneoID . " and TIPO=2";
$query_llave = mysql_query($sql_llave, $conn);
$aLlave = mysql_fetch_assoc($query_llave);

$sSqlJor = "
    SELECT 
        MIN(NUM_JOR) as min_jor
    FROM t_jornadas j
    WHERE j.ID_EVE=" . $aLlave['ID'] . "
    ORDER BY  j.NUM_JOR  ASC 
            ";
$oQueryJorLlaves = mysql_query($sSqlJor, $conn);
$aMinJor = mysql_fetch_assoc($oQueryJorLlaves);
$nFirstJor = $aMinJor['min_jor'];

$sSqlJor = "
    DELETE FROM t_jornadas
    WHERE (t_jornadas.ID_EVE=" . $aLlave['ID'] . ") ";
$oQueryjornadas = mysql_query($sSqlJor, $conn);

$sSqlEven = "
    DELETE FROM t_even_equip
    WHERE ID_EVEN=" . $aLlave['ID'];
$oQueryEquiEven = mysql_query($sSqlEven, $conn);

$sSqlEstEqui = "
    UPDATE t_est_equi 
        SET 	
            PAR_JUG_ACU=PAR_JUG,
            PAR_GAN_ACU=PAR_GAN,
            PAR_EMP_ACU=PAR_EMP,
            PAR_PER_ACU=PAR_PER,
            GOL_ANO_ACU=GOL_ANO,
            GOL_RES_ACU=GOL_RES,
            PTS_ACU=PTS,
            POSICION=0,
            PR_MEN_BATIDO=0,
            PR_MEJ_OFEN=0,
            PR_MAS_DISC=0,
            PR_CAM_RECOPA=0
    WHERE t_est_equi.ID_TORNEO=" . $nTorneoID;
$oQueryEquiEst = mysql_query($sSqlEstEqui, $conn);

$sSql = "
    DELETE FROM t_est_jug_disc
    WHERE 
        ID_TORNEO=" . $nTorneoID . "
        AND JORNADA>=" . $nFirstJor;
$oQueryEstJug = mysql_query($sSql, $conn);



echo "<script type=\"text/javascript\">
   		alert('Las jornadas de llaves y estadisticas de equipos se han borrado');
		document.location.href='torneo.php';
	</script>";
?>