<?php

//namespace Torneo;

class Torneo {

    function __construct() {
        
    }

    public function getTorneoByID($psToneoID = '0') {
        $aReturn = array();
        $sSql = "SELECT * FROM t_torneo WHERE ID='" . $psToneoID . "'";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
        }
        return $aReturn;
    }

    public function valEquiposIngresados($psToneoID = '0') {
        $nNum = 0;
        $sSql = "
            SELECT 
            COUNT(*) NUM_REG 
            FROM 
            t_even_equip ee
            LEFT JOIN t_eventos e on ee.ID_EVEN = e.ID
            LEFT JOIN t_torneo t on t.ID = e.ID_TORNEO
            WHERE 
            t.ID='" . $psToneoID . "'";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
            $nNum = $aReturn['NUM_REG'];
        }
        return $nNum;
    }

    public function sumarInstancia($psTorneoID = '0') {
        $sSql = "UPDATE t_torneo 
                SET 
                    INSTANCIA = INSTANCIA + 1
		WHERE ID='" . $psTorneoID . "'";
        $oQuery = mysql_query($sSql);
    }

}

?>