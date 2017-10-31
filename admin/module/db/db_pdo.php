<?php

namespace db;

class db_pdo {

    function __construct() {
        
    }

    private function Conect($psHostName = DB_SERVER, $psUserName = DB_SERVER_USERNAME, $psPassword = DB_SERVER_PASSWORD, $psDataBaseName = DB_DATABASE) {
        $oDBH = FALSE;
        $sMsj = '';

        try {
            $oDBH = new \PDO("mysql:host=$psHostName;dbname=$psDataBaseName", $psUserName, $psPassword);
            $oDBH->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $sMsj = 'Connected to database';
        } catch (PDOException $e) {
            $sMsj = $e->getMessage();
        }

        return array(
            'dbConn' => $oDBH,
            'menssage' => $sMsj
        );
    }

    public function Close($psDBConn = 'db_link') {
        $psDBConn = null;
    }

#---------------------------------------------- insert delete update ---------------------------------------------------------------------------------------------------------

    public function execInsertUpdate($psSql) {
        $aoDBH = $this->Conect();
        $oDBH = $aoDBH['dbConn'];
        $nCount = 0;
        $bStatus = FALSE;
        $nId = NULL;
        $sMsj = '';

        try {
            if ($oDBH != FALSE) {
                $nCount = $oDBH->exec($psSql);
                $nId = $oDBH->lastInsertId();
            }

            if ($nCount > 0) {
                $bStatus = TRUE;
            }
        } catch (PDOException $e) {
            $bStatus = FALSE;
            $sMsj = $e->getMessage();
        }

        $this->close($oDBH);
        return array(
            'lastId' => $nId,
            'rowsAffected' => $nCount,
            'status' => $bStatus,
            'menssage' => $sMsj,
        );
    }

    function easyInsertUpdate($pnType = 0, $psTableName = '', $paFields = array(), $psParameters = '') {
        $sSql = '';
        $sTableColums = '';
        $sTableColumsValue = '';
        $nI = 0;
        $sComa = '';
        $aResult = array();
        $bStatus = FALSE;

//insert 
        if ($pnType == 0) {
            foreach ($paFields as $sColumsName => $sColumsValue) {
                $sTableColums .= $sComa . $sColumsName;
                $sTableColumsValue .= $sComa . $this->validarField($sColumsValue);

                if ($nI == 0) {
                    $sComa = ',';
                }
                $nI++;
            }
            $sSql = "insert into " . $psTableName . " (" . $sTableColums . ") values (" . $sTableColumsValue . ")";
        } elseif ($pnType == 1) {
            foreach ($paFields as $sColumsName => $sColumsValue) {
                $sTableColumsValue .= $sComa . $sColumsName . " = " . $this->validarField($sColumsValue);

                if ($nI == 0) {
                    $sComa = ',';
                }
                $nI++;
            }
            $sSql = "update " . $psTableName . " set " . $sTableColumsValue . " where " . $psParameters;
        }


        if (($pnType >= 0 && $pnType <= 1) && ($nI > 0)) {
            $aResult = $this->execInsertUpdate($sSql);
            $bStatus = true;
        }

        return array(
            'dataResult' => $aResult,
            'status' => $bStatus,
            'type' => $pnType,
        );
    }

    public function execTransaction($psSql) {
        $aoDBH = $this->Conect();
        $oDBH = $aoDBH['dbConn'];
        $sMsj = '';
        $nCount = 0;
        $bStatus = FALSE;
        $nId = NULL;

        try {
            $oDBH->beginTransaction();

            if ($oDBH != FALSE) {
                $nCount = $oDBH->exec($psSql);
                $nId = $oDBH->lastInsertId();
            }

            if ($nCount > 0) {
                $bStatus = TRUE;
            }

            $oDBH->commit();
        } catch (PDOException $e) {
            $oDBH->rollback();
            $sMsj = $e->getMessage();
        }

        $this->close($oDBH);
        return array(
            'lastId' => $nId,
            'rowsAffected' => $nCount,
            'status' => $bStatus
        );
    }

    private function validarField($psField) {
        $sResult = '';

        switch ((string) $psField) {
            case 'now()':
                $sResult = 'now()';
                break;
            case 'null':
                $sResult = 'null';
                break;
            default:
                $sResult = "'" . $this->inputDBData($psField) . "'";
                break;
        }

        return $sResult;
    }

#----------------------------------------------------------------- SELECT ----------------------------------------------------------------

    public function execSelect($psSql) {
        $oDBSource = $this->performQuery($psSql);
        $aResult = $this->getDataSet($oDBSource);
        return $aResult;
    }

    private function performQuery($psSql) {
        $aoDBH = $this->Conect();
        $oDBH = $aoDBH['dbConn'];
        $sMsj = '';
        $oDBSource = NULL;
        $bStatus = FALSE;

        if ($oDBH != FALSE) {
            try {
                $oDBSource = $oDBH->query($psSql);
                $bStatus = TRUE;
            } catch (PDOException $e) {
                $sMsj = $e->getMessage();
            }
        }

        return array(
            'source' => $oDBSource,
            'status' => $bStatus,
            'menssage' => $sMsj
        );
    }

    private function getDataSet($poDBSource) {
        $aReturn = array();
        $nI = 0;
        $oSource = $poDBSource['source'];
        $Status = $poDBSource['status'];

        if ($Status) {
            while ($aResult = $oSource->fetch(\PDO::FETCH_ASSOC)) {
                foreach ($aResult as $sKey => $sVal) {
                    $aReturn[$nI][$sKey] = $sVal;
                }
                $nI++;
            }
        }

        return $aReturn;
    }

    #---------------------------------------------- helpers funtions ------------------------------

    public function charsEncoder($psString) {
        $psString = str_replace("'", '&#39', $psString);
        return $psString;
    }

    public function charsDecoder($psString) {
        $psString = str_replace('&#39', "'", $psString);
        return $psString;
    }

    public function prepareData($psData) {
        if (is_string($psData)) {
            $psData = trim(stripslashes($psData));
        } elseif (is_array($psData)) {
            foreach ($psData as $key => $value) {
                $psData[$key] = $this->prepareData($value);
            }
        }
        return $psData;
    }

    public function outputDBData($psString) {
        return htmlspecialchars($psString);
    }

    public function inputDBData($psString) {
        return addslashes($psString);
    }

}

?>
