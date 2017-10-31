<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';

$oTorneo = new torneo();
$oEventos = new eventos();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEventoGrupos = $oEventos->getEvenByInstancia($sTorVerID, '1');
$aEventoLLaves = $oEventos->getEvenByInstancia($sTorVerID, '2');

if (count($aEventoGrupos) == 0) {
    $aEventoGrupos['ID'] = 0;
}



$condicion_query = " WHERE ((ID_EVE=" . $aEventoGrupos['ID'] . ") OR (ID_EVE=" . $aEventoLLaves['ID'] . ")) 
and ((t_jornadas.ESTADO=4) OR (t_jornadas.ESTADO=3))";

//consultar el maximo de jornadas
$cadena_max_jor = "SELECT MAX(NUM_JOR) FROM t_jornadas " . $condicion_query;
$consulta_max_jor = mysql_query($cadena_max_jor, $conn);
$fila_max_jor = mysql_fetch_assoc($consulta_max_jor);

//consultar los equipo con los goles por jornada
$cadena_equipos = "SELECT *,	
			IF (t_jornadas.ID_EQUI_CAS<>t_equipo.ID,
			IFNULL(t_jornadas.MARCADOR_CASA,0),
			IFNULL(t_jornadas.MARCADOR_VISITA,0))AS TOTAL_JOR,
			t_equipo.ID AS ID_EQUI  
		FROM  t_equipo
		LEFT JOIN t_jornadas ON (t_equipo.ID=t_jornadas.ID_EQUI_CAS) OR (t_equipo.ID=t_jornadas.ID_EQUI_VIS)
		" . $condicion_query . "
		ORDER BY t_equipo.ID ASC,t_jornadas.NUM_JOR ASC";
$consulta_equipos = mysql_query($cadena_equipos, $conn);
$cant_jornadas = mysql_num_rows($consulta_equipos);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2>Arco Menos Batido</h2>
<hr/>
<?php
if ($cant_jornadas > 0) {
    //**********************************recorrer la consulta y guardar los equipos en un array y ordenarlos********************************88										
    $id_actual = 0;
    $equipos = null;
    $fila = -1;
    $columna = 0;
    $acumulador = 0;
    $contadorNegativo = 0;
    //recorrer las filas de la consulta
    while ($fila_equipos = mysql_fetch_assoc($consulta_equipos)) {
        //condicion para evaluar si la siguiente columna el id del equipo es el mismo
        if ($fila_equipos['ID_EQUI'] == $id_actual) {
            $equipos[$fila][$contador] = $fila_equipos['TOTAL_JOR'];
            $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];
            $contador++;
            $contadorNegativo++;
        } else {
            $equipos[$fila + 1][0] = $fila_equipos['NOMBRE'];
            $equipos[$fila + 1][1] = $fila_equipos['TOTAL_JOR'];

            if ($fila != -1) {
                $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 1] = $acumulador;
                if ($acumulador > 0) {
                    $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 2] = $acumulador / ($contadorNegativo - 1);
                }
            }

            $acumulador = 0;
            $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];
            $contadorNegativo = 2;
            $id_actual = $fila_equipos['ID_EQUI'];
            $contador = 2;
            $fila++;
        }

        if (($fila_equipos['ID_EQUI_CAS'] == 0) || ($fila_equipos['ID_EQUI_VIS'] == 0)) {
            $contadorNegativo = $contadorNegativo - 1;
        }
    }//fin while
    $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];
    $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 1] = $acumulador;
    $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 2] = $acumulador / ($contadorNegativo - 1);

    foreach ($equipos as $key => $fila) {
        $totales[$key] = $fila[$fila_max_jor['MAX(NUM_JOR)'] + 2]; // columna de animales
    }

    //ordenar los equipos por porcentage
    array_multisort($totales, SORT_ASC, $equipos);
    ?>

    <table cellpadding="0" cellspacing="0" class="table_content">
        <tr >
            <td >Po.</td>
            <td >Equipo </td>
            <?php
            for ($i = 1; $i <= $fila_max_jor['MAX(NUM_JOR)']; $i++) {
                echo ' <td >' . $i . ' F</th>';
            }
            ?>
            <td > Total </td>
            <td >Prome.</td>
        </tr>
        <?php
        //llenar con equipos					
        for ($a = 0; $a < count($equipos); $a++) {
            echo '
		<tr>
			<td>' . ($a + 1) . '</td>';
            for ($i = 0; $i <= $fila_max_jor['MAX(NUM_JOR)'] + 2; $i++) {
                if ($i != $fila_max_jor['MAX(NUM_JOR)'] + 2) {
                    echo '
                        <td>' . $equipos[$a][$i] . '&ensp;</td>';
                } else {
                    echo '
                        <td>' . number_format($equipos[$a][$i], 2) . '&ensp;</td>';
                }
            }
            echo'
		</tr>';
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <p>Para mostrar la tabla del arco menos batido, se debe ingresar jornadas</p>
    <?php
}
?>
<?php
include('sec/inc.footer.php');
?>