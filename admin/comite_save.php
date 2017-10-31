<?php

include('conexiones/conec_cookies.php');

$sCargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '';
$nTipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$sNombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$sApellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : '';
$aFoto = (isset($_FILES['foto'])) ? $_FILES['foto'] : array();

$sSql = "
    select CARGO 
    from t_comite 
    where 
        CARGO='" . $sCargo . "' 
        and TIPO='" . $nTipo . "'";
$query = mysql_query($sSql);
$bandera = 0;

while ($row = mysql_fetch_assoc($query)) {
    if ($sCargo == $row['CARGO']) {
        $bandera = 1;
    }
}

$sPath = 'directiva/';
$sPath2 = '';
switch ($nTipo) {
    case '1':
        $sPath2 = 'disciplinario/';
        break;
    case '2':
        $sPath2 = 'competencia/';
        break;
    case '3':
        $sPath2 = 'apelacion/';
        break;
}

if ($bandera == 0) {
    if ($sNombre != '' and $sApellidos != '') {
        $sFotoURL = '';
        if ($nTipo != '') {

            if (is_uploaded_file($aFoto['tmp_name'])) {
                @mkdir($sPath . $sPath2 . $sNombre, 0777, true);
                copy($aFoto['tmp_name'], $sPath . $sPath2 . $sNombre . "/" . $aFoto['name']);
                $sFotoURL = $sPath . $sPath2 . $sNombre . "/" . $aFoto['name'];
            }
        }

        $sSql = "
            INSERT INTO t_comite 
            ( NOMBRE, APELLIDOS, CARGO, TIPO, URL_IMAGEN)
            VALUES 
                (
                '" . $sNombre . "',
                '" . $sApellidos . "',
                '" . $sCargo . "',
                '" . $nTipo . "',
                '" . $sFotoURL . "'
                )";

        $query = mysql_query($sSql);
        echo "
            <script type=\"text/javascript\">
            alert('Datos guardados correctamente');
            document.location.href='comites.php';
            </script>";
    } else {
        echo "
            <script type=\"text/javascript\">
            alert('Los campos con asterisco (*) son requeridos');
            history.go(-1);
            </script>";
    }
} else {
    echo "
        <script type=\"text/javascript\">
        alert('EL Cargo esta ocupado por favor verifique');
        history.go(-1);
        </script>";
}
?>
