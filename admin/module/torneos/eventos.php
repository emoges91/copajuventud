<?php

class eventos {

    function __construct() {
        
    }

    public function getEventosByID($psEventoId = '0') {
        $aReturn = array();
        $sSql = "
            SELECT 
                * 
            FROM t_eventos 
            WHERE 
                ID='" . $psEventoId . "' 
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
        }
        return $aReturn;
    }

    public function existFaseGrupos($psEvenID = '0') {
        $nNum = 0;
        $sSql = "
            SELECT 
                 MAX(ee.NUM_GRUP)  MAX_GRUP 
            FROM t_even_equip ee
            LEFT JOIN t_eventos e on e.ID=ee.ID_EVEN 
            WHERE 
                ee.ID_EVEN='" . $psEvenID . "' 
                AND e.TIPO='1'
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
            $nNum = $aReturn['MAX_GRUP'];
        }
        return $nNum;
    }

    public function totalGrupos($psEvenID = '0') {
        $nNum = 0;
        $sSql = "
            SELECT 
            MAX(ee.NUM_GRUP)  MAX_GRUP
            FROM t_even_equip ee
            WHERE 
                ee.ID_EVEN = '" . $psEvenID . "'
                ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);

        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
            $nNum = $aReturn['MAX_GRUP'];
        }
        return $nNum;
    }

    public function getEvenByInstancia($psTorneoId = '0', $psTorneoInstancia = '0') {
        $aReturn = array();
        $sSql = "
            SELECT 
                * 
            FROM t_eventos 
            WHERE 
                ID_TORNEO='" . $psTorneoId . "' 
                AND TIPO='" . $psTorneoInstancia . "'
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aReturn = mysql_fetch_assoc($oQuery);
        }
        return $aReturn;
    }

    public function updateEventoEquip($psEvento = '0', $psEquipo = '0', $psGrupo = '0') {
        //---------------------------se establece la relacion entre los equipos y eventos-----
        $sSql = "
                UPDATE t_even_equip 
                SET
                    NUM_GRUP='" . $psGrupo . "' 
                WHERE
                   ID_EQUI='" . $psEquipo . "'
                   AND ID_EVEN='" . $psEvento . "'
                    ";
        $oQuery = mysql_query($sSql);
    }

    public function addEquipoToEvento($psEquipoID = '0', $psEventoID = '0', $psNumGrupo = '0') {
        $nID = '0';
        $sSql = "INSERT INTO t_even_equip 
                    ( `NUM_GRUP`, `ID_EQUI`, `ID_EVEN`)
                VALUES 
                    (
                    '" . $psNumGrupo . "',
                    '" . $psEquipoID . "',
                    '" . $psEventoID . "'
                    )";
        $oQuery = mysql_query($sSql);
        $nID = mysql_insert_id();


        return $nID;
    }

}

?>