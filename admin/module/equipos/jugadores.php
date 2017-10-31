<?php

class jugadores {

    function __construct() {
        
    }

    public function getJugadoresByEquipo($pnTorneoID = '', $pnEquipoID = '0') {
        $aReturn = array();
        if ($pnEquipoID != '') {
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
                p.APELLIDO2,
                tep.TEP_ID,
                tep.TEP_STATUS
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
        }
        return $aReturn;
    }

    public function valRegTorneo($pnTorneoID, $pnPersonaID) {
        $nNum = 0;
        $sSql = "
             SELECT * 
             FROM  t_tor_equi_per 
             WHERE
                TEP_PER_ID = " . $pnPersonaID . " 
                AND TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND TEP_STATUS=1
                ";
        $oQuery = mysql_query($sSql);
        $nNum = mysql_num_rows($oQuery);
        RETURN $nNum;
    }

    public function valEnEquipo($pnEquipoID, $pnTorneoID, $pnPersonaID) {
        $nNum = 0;
        $sSql = "
             SELECT * 
             FROM  t_tor_equi_per 
             WHERE
                TEP_PER_ID = " . $pnPersonaID . " 
                AND TED_EQUIPO_ID = " . $pnEquipoID . " 
                AND TEP_TORNEO_ID = " . $pnTorneoID . " 
                AND TEP_STATUS=0
                ";
        $oQuery = mysql_query($sSql);
        $nNum = mysql_num_rows($oQuery);
        RETURN $nNum;
    }
    
    public function valEnEquipo2($pnEquipoID, $pnTorneoID, $pnPersonaID) {
        $nNum = 0;
        $sSql = "
             SELECT * 
             FROM  t_tor_equi_per 
             WHERE
                TEP_PER_ID = " . $pnPersonaID . " 
                AND TED_EQUIPO_ID = " . $pnEquipoID . " 
                AND TEP_TORNEO_ID = " . $pnTorneoID . "  
                ";
        $oQuery = mysql_query($sSql);
        $nNum = mysql_num_rows($oQuery);
        RETURN $nNum;
    }

}

?>