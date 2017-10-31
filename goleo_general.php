<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');


$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena);
$cant_tor = mysql_num_rows($consulta_torneo);
$fila_torneo = mysql_fetch_assoc($consulta_torneo);

include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila_torneo['NOMBRE'] . ' ' . $fila_torneo['YEAR']; ?> - Tabla de goleo general</h1>
    <hr/>

    <?php
    if ($cant_tor > 0) {

        //EJECUTAR CONSULTA
        //consulta grupos
        $str_grupos = "SELECT ID FROM t_eventos 
					WHERE TIPO=1 AND ID_TORNEO=" . $fila_torneo['ID'];
        $query_grupos = mysql_query($str_grupos, $conn);
        $fila_grupos = mysql_fetch_assoc($query_grupos);

        //consulta llaves
        $str_llaves = "SELECT ID FROM t_eventos 
					WHERE TIPO=2 AND ID_TORNEO=" . $fila_torneo['ID'];
        $query_llaves = mysql_query($str_llaves, $conn);
        $fila_llaves = mysql_fetch_assoc($query_llaves);

        $condicion_query = " WHERE (ID_EVE=" . $fila_grupos['ID'] . ") OR (ID_EVE=" . $fila_llaves['ID'] . ")";

        //consultar el maximo de jornadas
        $cadena_max_jor = "SELECT MAX(NUM_JOR) FROM t_jornadas " . $condicion_query;
        $consulta_max_jor = mysql_query($cadena_max_jor, $conn);
        $cant_max_jor = mysql_num_rows($consulta_max_jor);

        if ($cant_max_jor > 0) {
            $fila_max_jor = mysql_fetch_assoc($consulta_max_jor);

            //consultar el maximo de jornadas
            $cadena_equipos = "SELECT *,	
                                IF (t_jornadas.ID_EQUI_CAS=t_equipo.ID,
                                        IFNULL(t_jornadas.MARCADOR_CASA,0),
                                        IFNULL(t_jornadas.MARCADOR_VISITA,0)
                                )
                                AS TOTAL_JOR,t_equipo.ID AS ID_EQUI  
                                 FROM  t_equipo
                                LEFT JOIN t_jornadas ON (t_equipo.ID=t_jornadas.ID_EQUI_CAS) OR (t_equipo.ID=t_jornadas.ID_EQUI_VIS)
                                " . $condicion_query . "
                                ORDER BY t_equipo.ID ASC,t_jornadas.NUM_JOR ASC";
            $consulta_equipos = mysql_query($cadena_equipos, $conn);


            $id_actual = 0;
            $equipos = null;
            $fila = -1;
            $columna = 0;
            $acumulador = 0;
            while ($fila_equipos = mysql_fetch_assoc($consulta_equipos)) {
                if ($fila_equipos['ID_EQUI'] == $id_actual) {
                    $equipos[$fila][$contador] = $fila_equipos['TOTAL_JOR'];
                    $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];
                    $contador++;
                } else {
                    $equipos[$fila + 1][0] = $fila_equipos['NOMBRE'];
                    $equipos[$fila + 1][1] = $fila_equipos['TOTAL_JOR'];

                    if ($fila != -1) {
                        $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 1] = $acumulador;
                    }


                    $acumulador = 0;
                    $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];

                    $id_actual = $fila_equipos['ID_EQUI'];
                    $contador = 2;
                    $fila++;
                }
                /* echo $contador." ".$fila_equipos['ID_EQUI']." ".$id_actual; */
            }
            $acumulador = $acumulador + $fila_equipos['TOTAL_JOR'];
            $equipos[$fila][$fila_max_jor['MAX(NUM_JOR)'] + 1] = $acumulador;


            foreach ($equipos as $key => $fila) {
                $totales[$key] = $fila[$fila_max_jor['MAX(NUM_JOR)'] + 1]; // columna de animales
            }

            array_multisort($totales, SORT_DESC, $equipos);

            //$equipos=orderMultiDimensionalArray($equipos,'TOTAL_JOR',false);

            echo '
					<table class="table1">
					
						<tr id="titulo">
							<th>Nombre del equipo</th>';
            for ($i = 1; $i <= $fila_max_jor['MAX(NUM_JOR)']; $i++) {
                echo '
							<th>' . $i . ' F</th>';
            }
            echo'
							<th> Total </th>
						</tr>';

           
            for ($a = 0; $a <= count($equipos); $a++) {
           

                echo '
						<tr id="cuerpo">';
                for ($i = 0; $i <= $fila_max_jor['MAX(NUM_JOR)'] + 1; $i++) {
                    echo '
								<td>' . $equipos[$a][$i] . '</td>
							';
                }
                echo'
						</tr>';
            }


            echo'
					</table>';
        } else {
            echo '
					<h3>Las jornadas no han sidos creadas</h3>
					';
        }
    } else {
        echo '
				<h3>El torneo no ha sido posteado</h3>
				';
    }
    ?>
</div>
<?php
include 'inc.footer.php';
?>