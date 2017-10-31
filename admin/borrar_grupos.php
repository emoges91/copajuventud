<?php
include('conexiones/conec_cookies.php');

//-----------------------------------grupos----------------------------------------
$sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $_GET['id'] . " and TIPO=1";
$query_grupo = mysql_query($sql_grupo, $conn);
$row_grupo = mysql_fetch_assoc($query_grupo);

//--------------------------consulta eventos fase de llave-------------------------
$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $_GET['id'] . " and TIPO=2";
$query_llave = mysql_query($sql_llave, $conn);
$cant_llave = mysql_num_rows($query_llave);
if ($cant_llave > 0) {
    $row_llave = mysql_fetch_assoc($query_llave);
    $sSqlJorLlave = " OR (t_jornadas.ID_EVE=" . $row_llave['ID'] . ") ";
} else {
    $sSqlJorLlave = "";
}

$sSqlJor = "
    DELETE 
    FROM t_jornadas
    WHERE (t_jornadas.ID_EVE=" . $row_grupo['ID'] . ") " . $sSqlJorLlave ;
$oQueryJor = mysql_query($sSqlJor, $conn);

$sSql = "
    UPDATE t_est_equi 
    SET 	
        PAR_JUG=0,
        PAR_GAN=0,
        PAR_EMP=0,
        PAR_PER=0,
        GOL_ANO=0,
        GOL_RES=0,
        PTS=0,
        PAR_JUG_ACU=0,
        PAR_GAN_ACU=0,
        PAR_EMP_ACU=0,
        PAR_PER_ACU=0,
        GOL_ANO_ACU=0,
        GOL_RES_ACU=0,
        PTS_ACU=0,
        POSICION=0,
        PR_MEN_BATIDO=0,
        PR_MEJ_OFEN=0,
        PR_MAS_DISC=0,
        PR_CAM_RECOPA=0
    WHERE t_est_equi.ID_TORNEO=" . $_GET['id'];
$oQuery = mysql_query($sSql, $conn);

$sSql = "
    DELETE FROM 
    t_est_jug_disc  ejd
    WHERE ejd.ID_TORNEO=" . $_GET['id'];
$oQuery = mysql_query($sSql, $conn);

echo "<script type=\"text/javascript\">
   		alert('Las jornadas de grupos,estadisticas de equipos y estadisticas jugadores se han borrado');
		document.location.href='torneo.php';
	</script>";
?>