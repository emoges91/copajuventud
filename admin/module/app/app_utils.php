<?php

class app_utils {

    function __construct() {
        
    }

    static public function isPar($pnNumero = '0') {
        $bReturn = 1;
        if (($pnNumero % 2) != 0) {
            $bReturn = 0;
        }

        return $bReturn;
    }

    static public function isNumPositivo($pnNumero = '0') {
        $bReturn = 1;
        if (self::buscar_punto($pnNumero) == '1') {
            $bReturn = 0;
        }

        if (is_numeric($pnNumero) == FALSE) {
            $bReturn = 0;
        }

        if (trim($pnNumero) == '') {
            $bReturn = 0;
        }

        if ($pnNumero < 0) {
            $bReturn = 0;
        }

        return $bReturn;
    }

    static public function buscar_punto($cadena) {
        if (strrpos($cadena, "."))
            return 1;
        else
            return 0;
    }

    static public function cambiaf_a_normal($fecha) {
        ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
        return $lafecha;
    }

}

?>