<?php

include('conexiones/conec_cookies.php');

$sNombTor = (isset($_POST['NOMBRE'])) ? $_POST['NOMBRE'] : '';
$sEdiTor = (isset($_POST['EDICION'])) ? $_POST['EDICION'] : '';
$sFASE = (isset($_POST['FASE'])) ? $_POST['FASE'] : '1';

if ($sNombTor != '') {

//---------------------------crear el nuevo torneo-----------
    $sql = "
        INSERT INTO t_torneo 
        (`NOMBRE`, `YEAR`, `ACTUAL`, `INSTANCIA`, `MOSTRAR`)
        VALUES 
        (
        '" . $sNombTor . "', 
        '" . $sEdiTor . "',
        '1',
        '" . $sFASE . "',
        '0'
        )";
    $query = mysql_query($sql, $conn);
    $sTorneoID = mysql_insert_id();


//---------------------se crea los diferentes eventos-----------
    $nombre1 = "Grupos";
    $nombre2 = "Llaves";

    $sql = "insert into t_eventos VALUES(NULL,'" . $nombre1 . "'," . $sTorneoID . ",1);";
    $query = mysql_query($sql, $conn);
    $sql = "insert into t_eventos VALUES(NULL,'" . $nombre2 . "'," . $sTorneoID . ",2);";
    $query = mysql_query($sql, $conn);

    echo "
        <script type=\"text/javascript\">
                alert('Torneo ha sido creado correctamente');
                document.location.href='torneo_add_equipos.php?id_tor=" . $sTorneoID . "';
        </script>";
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Los campos con asterisco (*) son requeridos');
            history.go(-1);
	</script>";
}
?>