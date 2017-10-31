<?php

include('conexiones/conec_cookies.php');

$sEventoID = (isset($_POST['id_evento'])) ? $_POST['id_evento'] : '';
$sNumGrupos = (isset($_POST['num_grupos'])) ? $_POST['num_grupos'] : '';
$sJorGrupos = (isset($_POST['jornadas_grupo'])) ? $_POST['jornadas_grupo'] : '';

$i = 1;
$flag = 0;
while ($i <= $sNumGrupos) {
    $nombre_grupo = "g_" . $i;
    if (!(isset($_POST[$nombre_grupo]) and $_POST[$nombre_grupo] != '')) {
        $flag = 1;
    }
    $i++;
}

if (( $sJorGrupos != '') and ( $sNumGrupos != '') and ($flag == 0) and ($sEventoID != '')) {

    $valores1 = $sJorGrupos; //total de partidos
    for ($a = 1; $a <= $sNumGrupos; $a++) {

        $nombre_grupo = 'g_' . $a;
        $nombre_grupo2 = 'h_' . $a;
        $valores = $_POST[$nombre_grupo]; //total jornadas
        $valores2 = $_POST[$nombre_grupo2]; //total jornadas
        $residuo = count($valores) / $valores1[($a - 1)]; //cantidad de partidos por jornada
        //echo $residuo." ".count($valores)." ".$valores1[($a-1)];
        $jornada = 1;
        $conta = 0;
        for ($i = 0; $i < count($valores); $i++) {
            if ($conta == $residuo) {
                $jornada++;
                $conta = 0;
            }

            if ($valores[$i] == '') {
                $valores[$i] = 0;
            }
            if ($valores2[$i] == '') {
                $valores2[$i] = 0;
            }

            $estado = 0;
            if ($jornada == 1) {
                $estado = 2;
            }

            $sSql = "
                INSERT INTO t_jornadas 
                 (`ID_EQUI_CAS`, 
                 `ID_EQUI_VIS`, 
                 `ESTADO`, 
                 `NUM_JOR`, 
                 `ID_EVE`, 
                 `GRUPO`, 
                 `MARCADOR_CASA`, 
                 `MARCADOR_VISITA`) 
                VALUES (
                         " . $valores[$i] . ",
                         " . $valores2[$i] . ",
                         " . $estado . ",
                         " . $jornada . ",
                         " . $sEventoID . ",
                         " . $a . ",
                         null,
                         null);";
            $oQuery = mysql_query($sSql);

            $conta++;
        }
    }

    echo "<script type=\"text/javascript\">
            alert('Jornadas fueron registradas correctamente.');
            document.location.href='jornadas_grupos.php';
    </script>";
} else {
    echo "<script type=\"text/javascript\">
            alert('Verifique muy bien que el torneo aya sudi creado correctamente.');
            history.go(-1);
        </script>";
}
?>
