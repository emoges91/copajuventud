<?php

class personas {

    function __construct() {
        
    }

    public function getByEquipoAndTorneo($pnTorneoID = '', $pnEquipoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT * 
            FROM t_personas p
            LEFT JOIN t_tor_equi_per tep
                ON p.ID = tep.TEP_PER_ID
            WHERE 
                tep.TED_EQUIPO_ID = " . $pnEquipoID . "
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . "
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getByID($psPersonaID = '0') {
        $aReturn = array();
        if ($psPersonaID != '') {
            $sSql = "
            SELECT 
                p.ID, 
                p.CED, 
                p.NOMBRE, 
                p.APELLIDO1, 
                p.DIR, 
                p.TEL, 
                p.ACTIVO, 
                p.ID_EQUI, 
                p.APELLIDO2  
            FROM `t_personas` p 
            WHERE
                p.ID='" . $psPersonaID . "'
            ";
            $oQuery = mysql_query($sSql);
            $nCant = mysql_num_rows($oQuery);
            if ($nCant > 0) {
                $aReturn = mysql_fetch_assoc($oQuery);
            }
        }
        return $aReturn;
    }

    public function getByName($psPersonaName = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT 
                p.*, 
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Jugador' AND ID_TORNEO=" . $pnTorneoID . ") as JUG,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Director Tecnico' AND ID_TORNEO=" . $pnTorneoID . ") as DT,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Asistente' AND ID_TORNEO=" . $pnTorneoID . ") as DT_ASIS,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Representante' AND ID_TORNEO=" . $pnTorneoID . ") as REP,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Suplente' AND ID_TORNEO=" . $pnTorneoID . ") as REP_SUP
            FROM t_personas p
            WHERE 
                CONCAT( p.CED,' ', p.APELLIDO1,' ', p.APELLIDO2,' ', p.NOMBRE) like '%" . $psPersonaName . "%' 
            ORDER BY p.APELLIDO1 ASC,p.APELLIDO2 ASC, p.NOMBRE ASC
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getByIDAndTorneo($psPersonaID = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT 
                p.*, 
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Jugador' AND ID_TORNEO=" . $pnTorneoID . ") as JUG,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Director Tecnico' AND ID_TORNEO=" . $pnTorneoID . ") as DT,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Asistente' AND ID_TORNEO=" . $pnTorneoID . ") as DT_ASIS,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Representante' AND ID_TORNEO=" . $pnTorneoID . ") as REP,
                (select count(c.ID) from t_car_per c where c.ID_PERSONA=p.ID AND c.CARGO='Suplente' AND ID_TORNEO=" . $pnTorneoID . ") as REP_SUP
            FROM t_personas p
            WHERE 
                p.ID=" . $psPersonaID . "
            ORDER BY p.APELLIDO1 ASC,p.APELLIDO2 ASC, p.NOMBRE ASC
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getTotalJugadoresEquipo($psEquipoID = '', $pnTorneoID = '') {
        $aReturn = array();

         $sSql = "
            SELECT * 
            FROM t_tor_equi_per tep
            LEFT JOIN t_car_per c
                ON 
                    tep.TEP_PER_ID = c.ID_PERSONA 
                    AND tep.TEP_TORNEO_ID= c.ID_TORNEO
            WHERE 
                tep.TED_EQUIPO_ID = " . $psEquipoID . " 
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND c.CARGO='Jugador'
             ORDER BY tep.TEP_ID ASC 
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getTotalDTEquipo($psEquipoID = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT * 
            FROM t_tor_equi_per tep
            LEFT JOIN t_car_per c
                ON 
                    tep.TEP_PER_ID = c.ID_PERSONA 
                    AND tep.TEP_TORNEO_ID= c.ID_TORNEO
            WHERE 
                tep.TED_EQUIPO_ID = " . $psEquipoID . " 
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND c.CARGO='Director Tecnico'
             ORDER BY tep.TEP_ID ASC  
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getTotalDTSupEquipo($psEquipoID = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT * 
            FROM t_tor_equi_per tep
            LEFT JOIN t_car_per c
                ON 
                    tep.TEP_PER_ID = c.ID_PERSONA 
                    AND tep.TEP_TORNEO_ID= c.ID_TORNEO
            WHERE 
                tep.TED_EQUIPO_ID = " . $psEquipoID . " 
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND c.CARGO='Asistente'
             ORDER BY tep.TEP_ID ASC   
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getTotalRepEquipo($psEquipoID = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT * 
            FROM t_tor_equi_per tep
            LEFT JOIN t_car_per c
                ON 
                    tep.TEP_PER_ID = c.ID_PERSONA 
                    AND tep.TEP_TORNEO_ID= c.ID_TORNEO
            WHERE 
                tep.TED_EQUIPO_ID = " . $psEquipoID . " 
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND c.CARGO='Representante'
             ORDER BY tep.TEP_ID ASC    
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function getTotalRepSupEquipo($psEquipoID = '', $pnTorneoID = '') {
        $aReturn = array();

        $sSql = "
            SELECT * 
            FROM t_tor_equi_per tep
            LEFT JOIN t_car_per c
                ON 
                    tep.TEP_PER_ID = c.ID_PERSONA 
                    AND tep.TEP_TORNEO_ID= c.ID_TORNEO
            WHERE 
                tep.TED_EQUIPO_ID = " . $psEquipoID . " 
                AND tep.TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND c.CARGO='Suplente'
             ORDER BY tep.TEP_ID ASC     
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $nI = 0;
            while ($aRow = mysql_fetch_assoc($oQuery)) {
                $aReturn[$nI] = $aRow;
                $nI++;
            }
        }

        return $aReturn;
    }

    public function setEquipo($sTorVerID = '', $nEquipo = '', $nPersonaID = '') {
        $sSql = "
            INSERT INTO t_tor_equi_per
            (TEP_TORNEO_ID, TED_EQUIPO_ID, TEP_PER_ID)
            VALUES
            (" . $sTorVerID . "," . $nEquipo . "," . $nPersonaID . ")";
        $query = mysql_query($sSql);
    }

    public function updateStatus($sTorVerID = '', $nEquipo = '', $nPersonaID = '') {
        $sSql = "
            UPDATE t_tor_equi_per 
            SET
                TEP_STATUS=1
            WHERE
                TEP_TORNEO_ID=" . $sTorVerID . "
                AND TED_EQUIPO_ID=" . $nEquipo . "
                AND TEP_PER_ID=" . $nPersonaID . "";
        $query = mysql_query($sSql);
    }

    public function setCargo($sTorVerID = '', $nPersonaID = '', $sCargo = '') {
        $sSql = "
            INSERT INTO t_car_per (ID_PERSONA, CARGO, ID_TORNEO)
            VALUES ('" . $nPersonaID . "', '" . $sCargo . "'," . $sTorVerID . ")";
        $query = mysql_query($sSql);
    }

}

?>