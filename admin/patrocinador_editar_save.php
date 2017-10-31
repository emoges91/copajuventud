<?php

include('conexiones/conec_cookies.php');

$sEmpresa = (isset($_POST['empresa']) ? $_POST['empresa'] : '');
$sMostrar = (isset($_POST['mostrar']) ? $_POST['mostrar'] : '0');
$sDir = (isset($_POST['direccion']) ? $_POST['direccion'] : '');
$nPatrocinadorID = (isset($_POST['id']) ? $_POST['id'] : '');

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

if ($sEmpresa != '') {

    if ($_POST['bolean'] != '') {
        borrar_directorio('patrocinadores/' . $_POST['borrar'], true);
    }

    $sURLFoto = '';
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        @mkdir("patrocinadores/" . $sEmpresa, 0777, true);
        copy($_FILES['foto']['tmp_name'], "patrocinadores/" . $sEmpresa . "/" . $_FILES['foto']['name']);
        $sURLFoto = "patrocinadores/" . $sEmpresa . "/" . $_FILES['foto']['name'];
    }

    $sql = "
        UPDATE t_patrocinador 
            SET
                EMPRESA = '" . $sEmpresa . "',
                DIRECCION = '" . $sDir . "',
                MOSTRAR= '" . $sMostrar . "',
                URL = '" . $sURLFoto . "'
        WHERE ID = '" . $nPatrocinadorID . "'";

    $query = mysql_query($sql);
    
    echo "
        <script type=\"text/javascript\">
        alert('Patrocinador editado correctamente');
        document.location.href='patrocinador.php';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
        alert('Los campos con asterisco (*) son requeridos');
        history.go(-1);
        </script>";
}
?>