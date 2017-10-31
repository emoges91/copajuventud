<?php
include 'inc.head.php';

function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

$cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
$consulta_torneo = mysql_query($cadena, $conn);
$fila = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Llaves</h1>
    <hr/>


    <?php
    if ($cant_tor > 0) {
        echo '
		<table width="1035px" align="center">
			';

        //consulta eventos fase de llave
        $sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=2";
        $query_llave = mysql_query($sql_llave, $conn);
        $row_llave = mysql_fetch_assoc($query_llave);

        echo '
			<tr>
				<td>';

        //consulta eventos fase de grupos
        $sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=1";
        $query_grupo = mysql_query($sql_grupo, $conn);
        $row_grupo = mysql_fetch_assoc($query_grupo);

        //consulta para optener el ultimo grupo
        $cadena_ultimo_grupo = "SELECT MAX(t_even_equip.NUM_GRUP) FROM t_even_equip
				WHERE t_even_equip.ID_EVEN=" . $row_grupo['ID'];
        $consulta_ultimo_grupo = mysql_query($cadena_ultimo_grupo, $conn);
        $resultado_ultimo_grupo = mysql_fetch_assoc($consulta_ultimo_grupo);

        //consulta para obtener la ultima jornada
        $sql_ultima_jornada_grupos = "SELECT  MAX(t_jornadas.NUM_JOR) FROM t_jornadas
				WHERE t_jornadas.ID_EVE=" . $row_grupo['ID'];
        $consulta_ultima_jornada_grupos = mysql_query($sql_ultima_jornada_grupos, $conn);
        $row_ultima_jornada_grupos = mysql_fetch_assoc($consulta_ultima_jornada_grupos);


        //consulta para optener el ultimo grupo llaves
        $cadena_ultimo_grupo_llaves = "SELECT  MAX(t_jornadas.GRUPO) FROM t_jornadas
				WHERE t_jornadas.ID_EVE=" . $row_llave['ID'];
        $consulta_ultimo_grupo_llaves = mysql_query($cadena_ultimo_grupo_llaves, $conn);
        $resultado_ultimo_grupo_llaves = mysql_fetch_assoc($consulta_ultimo_grupo_llaves);

        //consulta para obtener la ultima jornada llaves
        $sql_ultima_jornada_llaves = "SELECT  MAX(t_jornadas.NUM_JOR) FROM t_jornadas
					WHERE t_jornadas.ID_EVE=" . $row_llave['ID'];
        $consulta_ultima_jornada_llaves = mysql_query($sql_ultima_jornada_llaves, $conn);
        $row_ultima_jornada_llaves = mysql_fetch_assoc($consulta_ultima_jornada_llaves);


        $sql_total_partidos = "SELECT * FROM t_jornadas
					WHERE t_jornadas.ID_EVE=" . $row_llave['ID'];
        $consulta_total_partidos = mysql_query($sql_total_partidos, $conn);
        $cant_partidos = mysql_num_rows($consulta_total_partidos);

        if (($cant_partidos > 0) && ($fila['INSTANCIA']) > 1) {

            $jornada = $row_ultima_jornada_grupos['MAX(t_jornadas.NUM_JOR)'];

            echo '
			<div id="itsthetable" class="tabla_1">
			<table align="center" class="tabla_prin">';
            $indicador_final = 0;
            while ($jornada < $row_ultima_jornada_llaves['MAX(t_jornadas.NUM_JOR)']) {

                $sql_partidos = "SELECT * FROM t_jornadas
					WHERE t_jornadas.ID_EVE=" . $row_llave['ID'] . " AND t_jornadas.NUM_JOR=" . ($jornada + 1) .
                        ' ORDER BY t_jornadas.GRUPO ASC ';
                $consulta_partidos = mysql_query($sql_partidos, $conn);
                $cant_partidos_fase = mysql_num_rows($consulta_partidos);

                $etiqueta = '';
                if ($cant_partidos_fase > 2) {
                    $etiqueta = 'Fase de ' . $cant_partidos_fase . 'avos de Final';
                } else if ($cant_partidos_fase == 2) {
                    if ($indicador_final < 2) {
                        $indicador_final++;
                        $etiqueta = 'Semifinales';
                    } else {
                        $etiqueta = 'Final y Tercer Lugar';
                    }
                } else {
                    $etiqueta = 'Final';
                }

                echo '
					<tr>
						<td colspan="9" >&nbsp;</td>
					</tr>
					<tr>
						<td colspan="9" >' . $etiqueta . '</td>
					</tr>
					<tr class="caption">
						<td colspan="9" align="center" style="color:#EEEEEE;">Jornada ' . ($jornada + 1) . '</td>
					</tr>
					<tr  style="color:#eee;" id="titulo">
						<td>&ensp;Equipo Casa&ensp;</td>
						<td>&ensp;Marcador&ensp;</td>
						<td>&ensp;Signo&ensp;</td>
						<td>&ensp;Equipo visita&ensp;</td>
						<td>&ensp;Marcador&ensp;</td>
						<td>&ensp;Fecha&ensp;</td>
						<td>&ensp;Estado&ensp;</td>
						<td>&ensp;Jornada&ensp;</td>
						<td>&ensp;Grupo&ensp;</td>
					</tr>';

                $clase = "";
                while ($fila_equipos = mysql_fetch_assoc($consulta_partidos)) {
                    //---------------cambiar colores-----------------
                    if ($indi == 0) {
                        $clase = ' class="normal"';
                        $indi = 1;
                    } else {
                        $clase = ' class="odd"';
                        $indi = 0;
                    }

                    //-------------------mostrar cuanto el equipo esta libre---------
                    if ($fila_equipos['ID_EQUI_CAS'] <> 0) {
                        $str_query_equi_casa = "SELECT * FROM t_equipo
							WHERE t_equipo.ID=" . $fila_equipos['ID_EQUI_CAS'];
                        $consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
                        $fila_equipo_casa = mysql_fetch_assoc($consulta_equi_casa);
                    } else {
                        $fila_equipo_casa['NOMBRE'] = 'LIBRE';
                    }

                    //-------------------mostrar cuanto el equipo esta libre---------
                    if ($fila_equipos['ID_EQUI_VIS'] <> 0) {
                        $str_query_equi_visita = "SELECT * FROM t_equipo
							WHERE t_equipo.ID=" . $fila_equipos['ID_EQUI_VIS'];
                        $consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
                        $fila_equipo_visita = mysql_fetch_assoc($consulta_equi_visita);
                    } else {
                        $fila_equipo_visita['NOMBRE'] = 'LIBRE';
                    }

                    if ($fila_equipos['MARCADOR_CASA'] == '') {
                        $marcador_casa = '-';
                    } else {
                        $marcador_casa = $fila_equipos['MARCADOR_CASA'];
                    }

                    if ($fila_equipos['MARCADOR_VISITA'] == '') {
                        $marcador_visita = '-';
                    } else {
                        $marcador_visita = $fila_equipos['MARCADOR_VISITA'];
                    }

                    $estado_partido = '';
                    switch ($fila_equipos['ESTADO']) {
                        case 0:$estado_partido = 'No jugado';
                            break;
                        case 1:$estado_partido = 'pendiente';
                            break;
                        case 2:$estado_partido = 'Siguiente';
                            break;
                        case 3:$estado_partido = 'Jugado';
                            break;
                        case 4:$estado_partido = 'Anterior';
                            break;
                        case 5:$estado_partido = 'Pendiente jugado';
                            break;
                    }

                    echo '
					<tr ' . $clase . ' id="cuerpo">
						<td align="center">' . $fila_equipo_casa['NOMBRE'] . '</td>
						<td align="center">' . $marcador_casa . '</td>
						<td align="center">Vrs</td>
						<td align="center">' . $fila_equipo_visita['NOMBRE'] . '</td>
						<td align="center">' . $marcador_visita . '</td>
						<td align="center">' . cambiaf_a_normal($fila_equipos['FECHA']) . '</td>
						<td align="center">' . $estado_partido . '</td>
						<td align="center">' . $fila_equipos['NUM_JOR'] . '</td>
						<td align="center">' . $fila_equipos['GRUPO'] . '</td>
					</tr>';
                }
                $jornada = ($jornada + 1);
            }
            echo '</table>
				</td>
			</tr>
		</table>
		</div>';
        } else {
               ?>
        <h3>Las jornadas de fase de llaves no se encuentran editadas</h3>
        <?php
            echo "</td>
			</tr>
			</table>";
        }
    } else {
        ?>
        <h3>Las jornadas del campeonato no se encuentran registradas</h3>
        <?php
    }
    ?>
</div>
<?php
include 'inc.footer.php';
?>