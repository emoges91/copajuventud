<?php

class jugadores_est {

    function __construct() {
        
    }

    public function save($pnTipo, $pnEstID, $psJorNum, $pnTorID, $pnJugID, $npEquipo, $pnAma, $pnRoj, $nGol) {

        if ($pnTipo == '0') {
            $sSql = "
            INSERT INTO t_est_jug_disc
                (
                    ID_TORNEO,
                    ID_EQUIPO,
                    ID_JUGADOR,
                    TAR_AMA,
                    TAR_ROJ,
                    JORNADA,
                    GOLEO
                )
            VALUES 
                (
                    " . $pnTorID . ",
                    " . $npEquipo . ",
                    " . $pnJugID . ",
                    " . $pnAma . ",
                    " . $pnRoj . ",
                    " . $psJorNum . ",
                    " . $nGol . "
                )
        ";
        } else {
            $sSql = "
            UPDATE t_est_jug_disc
                SET 
                    TAR_AMA=" . $pnAma . ",
                    TAR_ROJ=" . $pnRoj . ", 
                    GOLEO=" . $nGol . "
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
                ejd.ID, 
                ejd.ID_TORNEO, 
                ejd.ID_EQUIPO, 
                ejd.ID_JUGADOR, 
                ejd.TAR_AMA, 
                ejd.TAR_ROJ, 
                ejd.JORNADA, 
                ejd.GOLEO  
            FROM t_est_jug_disc ejd  
            WHERE
                ejd.JORNADA = " . $psJorNum . "
                AND ejd.ID_TORNEO = " . $pnTorID . "
                AND ejd.ID_EQUIPO = " . $npEquipo . "
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

    public function getJugData($paEst, $pnJug) {

        $nAma = '0';
        $nRoj = '0';
        $nGol = '0';
        $nID = '';
        for ($nIndex = 0; $nIndex < count($paEst); $nIndex++) {
            if ($paEst[$nIndex]['ID_JUGADOR'] == $pnJug) {
                $nAma = $paEst[$nIndex]['TAR_AMA'];
                $nRoj = $paEst[$nIndex]['TAR_ROJ'];
                $nGol = $paEst[$nIndex]['GOLEO'];
                $nID = $paEst[$nIndex]['ID'];
            }
        }

        return array(
            'ama' => $nAma,
            'roj' => $nRoj,
            'gol' => $nGol,
            'id' => $nID,
        );
    }

}

?>