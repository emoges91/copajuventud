<?php

class equipos_est {

    function __construct() {
        
    }

    public function save($pnTipo, $pnEstID, $psJorNum, $pnTorID, $npEquipo, $pnAma) {

        if ($pnTipo == '0') {
            $sSql = "
            INSERT INTO t_est_equi_disc
                (
                    ID_TORNEO,
                    ID_EQUIPO,
                    TAR_AMA,  
                    JORNADA 
                )
            VALUES 
                (
                    " . $pnTorID . ",
                    " . $npEquipo . ", 
                    " . $pnAma . ", 
                    " . $psJorNum . " 
                )
            ";
        } else {
            $sSql = "
            UPDATE t_est_equi_disc
                SET 
                    TAR_AMA=" . $pnAma . ", 
                    JORNADA= " . $psJorNum . " 
            WHERE 
                ID='" . $pnEstID . "'
            ";
        }

        $oQuery = mysql_query($sSql);
    }
    
    public function getInfo($psJorNum, $pnTorID, $npEquipo) {
        $aReturn = array();
        if ($psJorNum != '') {
            $sSql = "
            SELECT 
                eed.ID, 
                eed.ID_TORNEO, 
                eed.ID_EQUIPO,  
                eed.TAR_AMA,  
                eed.JORNADA   
            FROM t_est_equi_disc eed  
            WHERE
                eed.JORNADA = " . $psJorNum . "
                AND eed.ID_TORNEO = " . $pnTorID . "
                AND eed.ID_EQUIPO = " . $npEquipo . "
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

}

?>