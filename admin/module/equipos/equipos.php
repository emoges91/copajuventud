<?php

class equipos {

    function __construct() {
        
    }

    public function getByID($psEquipoID = '0') {
        $aReturn = array();

            $sSql = "
            select 
              DISTINCT  
                eq.ID as EQ_ID,
                eq.url,
                eq.NOMBRE as EQ_NOMBRE, 
                eq.ACTIVO as EQ_ACTIVO, 
                eq.CAN_OFI as EQ_OFI, 
                eq.CAN_ALT as EQ_ALT, 
                eq.url as EQ_URL,
                (co.NOMBRE) CO_NOMBRE,
                (ca.NOMBRE) CA_NOMBRE
            from t_equipo eq
            LEFT JOIN t_cancha co ON eq.CAN_OFI=co.ID
            LEFT JOIN t_cancha ca ON eq.CAN_ALT=ca.ID
            WHERE eq.ID = '" . $psEquipoID . "'
            ORDER BY eq.NOMBRE";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aRow = mysql_fetch_assoc($oQuery);
            $aReturn = $aRow;
        }

        return $aReturn;
    }

    public function getEquiposByID($psEquipoID = '0') {
        $aReturn = array();

        $sSql = "
            select 
            * ,
            eq.ID as EQ_ID, 
            eq.NOMBRE as EQ_NOMBRE, 
            eq.ACTIVO as EQ_ACTIVO, 
            eq.CAN_OFI as EQ_OFI, 
            eq.CAN_ALT as EQ_ALT, 
            eq.url as EQ_URL 
            from t_equipo eq
            LEFT JOIN t_even_equip ee on eq.id =ee.ID_EQUI
            LEFT JOIN t_eventos e on e.id =ee.ID_EVEN
            WHERE
                eq.ID='" . $psEquipoID . "'
            ";
        $oQuery = mysql_query($sSql);
        $nCant = mysql_num_rows($oQuery);
        if ($nCant > 0) {
            $aRow = mysql_fetch_assoc($oQuery);
            $aReturn = $aRow;
        }

        return $aReturn;
    }

    public function getEquiposByTorneo($psTorneoID = '0') {
        $aReturn = array();

        $sSql = "
            select 
            * ,
            eq.ID as EQ_ID, 
            eq.NOMBRE as EQ_NOMBRE, 
            eq.ACTIVO as EQ_ACTIVO, 
            eq.CAN_OFI as EQ_OFI, 
            eq.CAN_ALT as EQ_ALT, 
            eq.url as EQ_URL 
            from t_equipo eq
            LEFT JOIN t_even_equip ee on eq.id =ee.ID_EQUI
            LEFT JOIN t_eventos e on e.id =ee.ID_EVEN
            WHERE
                e.ID_TORNEO='" . $psTorneoID . "'
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

    public function getEquiposByGrupo($psEventoID = '0', $psGrupoNUM = '0') {
        $aReturn = array();
        $sSql = "
            SELECT 
            * 
            FROM t_even_equip ee
            LEFT JOIN t_equipo e ON ee.ID_EQUI=e.ID
            WHERE 
                ee.ID_EVEN=" . $psEventoID . " 
                and ee.NUM_GRUP=" . $psGrupoNUM . " 
            ORDER BY ee.ID";
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

    public function getEquiposByEvento($psEventoID = '0') {
        $aReturn = array();

        $sSql = "
            select 
            * ,
            eq.ID as EQ_ID, 
            eq.NOMBRE as EQ_NOMBRE, 
            eq.ACTIVO as EQ_ACTIVO, 
            eq.CAN_OFI as EQ_OFI, 
            eq.CAN_ALT as EQ_ALT, 
            eq.url as EQ_URL 
            from t_equipo eq
            LEFT JOIN t_even_equip ee on eq.id =ee.ID_EQUI
            LEFT JOIN t_eventos e on e.id =ee.ID_EVEN
            WHERE
                ee.ID_EVEN='" . $psEventoID . "'
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

}

?>