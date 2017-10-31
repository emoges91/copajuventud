<?php

include ('conexiones/conec_cookies.php');

$nTipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$sNombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$sApellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : '';
$nComiteID = (isset($_POST['id'])) ? $_POST['id'] : '';
$aFoto = (isset($_FILES['foto'])) ? $_FILES['foto'] : array();
$nTipoDir = (isset($_POST['tipo_dir'])) ? $_POST['tipo_dir'] : '';
$sNombFoto = (isset($_POST['nomb_foto'])) ? $_POST['nomb_foto'] : '';
$sCargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '';

function borrar_directorio($psDir, $bBorrarme) {
    if (!$dh = @opendir($psDir))
        return;
    while (false !== ($obj = readdir($dh))) {
        if ($obj == '.' || $obj == '..')
            continue;
        if (!@unlink($psDir . '/' . $obj))
            borrar_directorio($psDir . '/' . $obj, true);
    }
    closedir($dh);
    if ($bBorrarme) {
        @rmdir($psDir);
    }
}

$sPath = 'directiva/';
$sPath2 = '';

switch ($nTipoDir) {
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

if ($nTipoDir != '') {
    borrar_directorio($sPath . $sPath2 . $sNombFoto, true);
}


if ($sNombre != '' and $sApellidos != '') {
    $sFotoURL = '';
    if ($nTipo != '') {
        if (is_uploaded_file($aFoto['tmp_name'])) {
            @mkdir($sPath . $sPath2 . $sNombre, 0777, true);
            copy($aFoto['tmp_name'], $sPath . $sPath2 . $sNombre . "/" . $aFoto['name']); 
            $sFotoURL = $sPath . $sPath2 . $sNombre . "/" . $aFoto['name'];
        }
    }
    $sql = "
            UPDATE t_comite 
                SET
                    NOMBRE = '" . $sNombre . "',
                    APELLIDOS = '" . $sApellidos . "',
                    TIPO = '" . $nTipo . "',
                    URL_IMAGEN = '" . $sFotoURL . "',
                    CARGO = '" . $sCargo . "'
            WHERE ID = '" . $nComiteID . "'";
    @$query = mysql_query($sql, $conn);

    echo "
            <script type=\"text/javascript\">
            alert('Miembro directivo editado correctamente');
            document.location.href='comites.php';
            </script>";
} else {
    echo "
            <script type=\"text/javascript\">
            alert('Los campos con asterisco (*) son requeridos');
            history.go(-1);
            </script>";
}
?>