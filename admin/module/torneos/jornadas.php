<?php

class jornadas {

    function __construct() {
        
    }

    public function getJornadasByID($psJornadaID = '0') {
        $aReturn = array();
        $sSql = "
            SELECT 
                * ,
                j.ID as JOR_ID,
                 IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                 IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                 IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                 IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                  tjs.TJS_NOMBRE 
            FROM t_jornadas j
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID ='" . $psJornadaID . "' 
               
            ORDER BY 
                j.NUM_JOR ASC,
                j.GRUPO ASC ,
                j.`ID`
                ";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $aJornada = mysql_fetch_assoc($oQueryJornadas);
            $aReturn = $aJornada;
        }
        return $aReturn;
    }

    public function getJornadasGrupos($psEventoID = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
            j.ID_EVE='" . $psEventoID . "'
            ORDER BY 
                ev.ID,
                j.`NUM_JOR` ASC,
                j.`GRUPO` ASC,
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function getJornadasGruposByGrupo($psEventoID = '0', $psGrupo = '') {
        $aReturn = array();
        $sSql = "
            SELECT 
                * ,
                j.ID as JOR_ID,
                 IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                 IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                 IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                 IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                  tjs.TJS_NOMBRE 
            FROM t_jornadas j
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID_EVE='" . $psEventoID . "' 
                AND j.GRUPO='" . $psGrupo . "'
            ORDER BY 
                j.NUM_JOR ASC,
                j.GRUPO ASC ,
                j.`ID`
                ";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function revisarMatriz() {
        
    }

    public function getMaxJornadas($psEventoID = '0', $psGrupo = '') {
        $nNum = 0;
        $sSql = "
            SELECT  
            MAX(`NUM_JOR`) as MAX_JOR 
            FROM t_jornadas
            WHERE t_jornadas.ID_EVE ='" . $psEventoID . "' 
            AND GRUPO ='" . $psGrupo . "'
            ORDER BY t_jornadas.NUM_JOR ASC , t_jornadas.GRUPO ASC 
                ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
            $nNum = $aReturn['MAX_JOR'];
        }
        return $nNum;
    }

    public function getMaxJornadasByEvento($psEventoID = '0') {
        $nNum = 0;
        $sSql = "
            SELECT  
            MAX(`NUM_JOR`) as MAX_JOR 
            FROM t_jornadas
            WHERE t_jornadas.ID_EVE ='" . $psEventoID . "' 
            ORDER BY t_jornadas.NUM_JOR ASC , t_jornadas.GRUPO ASC 
                ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
            $nNum = $aReturn['MAX_JOR'];
        }
        return $nNum;
    }

    public function getJorByID($psJornadaID = '0') {
        $aReturn = array();
        $sSql = "
             SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
            j.ID='" . $psJornadaID . "'
          
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
        }
        return $aReturn;
    }

    public function getJonadasSiguentes($psEventoID = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID_EVE='" . $psEventoID . "'
                 AND j.ESTADO=2 
            ORDER BY 
                ev.ID,
                j.`NUM_JOR` ASC,
                j.`GRUPO` ASC,
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function getJonadasPendientes($psEventoID = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID_EVE='" . $psEventoID . "'
                 AND j.ESTADO=1 
            ORDER BY 
                ev.ID,
                j.`NUM_JOR` ASC,
                j.`GRUPO` ASC,
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function getTotalJornadasPendientes($psEventoID = '0') {
        $sSql = "
            SELECT 
            * 
            FROM t_jornadas 
            WHERE 
                ESTADO=1 
                AND ID_EVE = '" . $psEventoID . "'";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        return $nCant;
    }

    public function getTotalJornadasSiguientes($psEventoID = '0') {
        $sSql = "
            SELECT 
            * 
            FROM t_jornadas 
            WHERE 
                ESTADO=2
                AND ID_EVE = '" . $psEventoID . "'";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        return $nCant;
    }

    public function setJornadasToJugadas($psEventoID = '0', $psNumJornada = '0') {
        $sSql = "
            UPDATE t_jornadas 
            SET 
                ESTADO=3
            WHERE 
                NUM_JOR = '" . $psNumJornada . "' 
                AND ID_EVE = '" . $psEventoID . "'";
        $oQuery = mysql_query($sSql);
    }

    public function setJornadasToJugadasByEvento($psEventoID = '0') {
        $sSql = "
            UPDATE t_jornadas 
            SET 
                ESTADO=3
            WHERE 
                 ID_EVE = '" . $psEventoID . "'";
        $oQuery = mysql_query($sSql);
    }

    public function setJornadasToSiguientes($psEventoID = '0', $psNumJornada = '0') {
        $sSql = "
            UPDATE t_jornadas 
            SET 
                ESTADO=2
            WHERE 
                NUM_JOR = '" . $psNumJornada . "' 
                AND ID_EVE = '" . $psEventoID . "'";
        $oQuery = mysql_query($sSql);
    }

    public function saveJornada($paCampos = array()) {
        $nID = '0';
        if (count($paCampos) > 0) {
            $sSql = "INSERT INTO t_jornadas 
                    ( 
                    `ID_EQUI_CAS`, 
                    `ID_EQUI_VIS`, 
                    `ESTADO`, 
                    `NUM_JOR`, 
                    `ID_EVE`, 
                    `GRUPO`)
                    VALUES 
                    (
                    " . $paCampos['EquiCasaID'] . ",
                    " . $paCampos['EquiVisitaID'] . ",
                     " . $paCampos['Estado'] . ",
                    " . $paCampos['NumJornada'] . ",
                    " . $paCampos['EveID'] . ",
                    " . $paCampos['Grupo'] . "
                   )";
            $oQuery = mysql_query($sSql);
            $nID = mysql_insert_id();
        }

        return $nID;
    }

    public function getJornadasByNumJor($psEventoID = '0', $nNumJor = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
            FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID_EVE='" . $psEventoID . "'
                AND j.NUM_JOR='" . $nNumJor . "'
            ORDER BY 
                ev.ID,
                j.`NUM_JOR` ASC,
                j.`GRUPO` ASC,
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function getJornadasLlavesByJornadas($psEventoID = '0', $psJornada1 = '0', $psJornada2 = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.ID_EVE='" . $psEventoID . "' 
                AND (j.NUM_JOR='" . $psJornada1 . "' OR j.NUM_JOR='" . $psJornada2 . "')
            ORDER BY 
                ev.ID,
                j.`GRUPO` ASC,
                j.`NUM_JOR` ASC,
                
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

    public function updateLlaves($psJorID = '0', $psEquipoCasa = '0', $psEquipoVis = '0') {
        $sSql = "
            UPDATE t_jornadas 
            SET 
                ID_EQUI_CAS=" . $psEquipoCasa . ",
                ID_EQUI_VIS=" . $psEquipoVis . "
            WHERE ID=" . $psJorID . "";
        $oQuery = mysql_query($sSql);
    }

    public function updateHorarios($psJorID = '0', $psFecha = '', $psHora = '', $psCancha = '') {
        $sSql = "
            UPDATE t_jornadas 
            SET 
                FECHA='" . $psFecha . "',
                HORA='" . $psHora . "',
                CANCHA='" . $psCancha . "' 
            WHERE ID=" . $psJorID . "";
        $oQuery = mysql_query($sSql);
    }

    public function getJornadasByNumJor2($psTorneoID = '0', $nNumJor = '0') {
        $aReturn = array();

        $sSql = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    j.CANCHA,
                    j.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
            FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
                j.NUM_JOR='" . $nNumJor . "' 
                AND t.ID='" . $psTorneoID . "'
            ORDER BY 
                ev.ID,
                j.`NUM_JOR` ASC,
                j.`GRUPO` ASC,
                j.`ID`";
        $oQueryJornadas = mysql_query($sSql);
        $nCant = mysql_num_rows($oQueryJornadas);

        if ($nCant > 0) {
            $nI = 0;
            while ($aJornada = mysql_fetch_assoc($oQueryJornadas)) {
                $aReturn[$nI] = $aJornada;
                $nI++;
            }
        }
        return $aReturn;
    }

}

?>