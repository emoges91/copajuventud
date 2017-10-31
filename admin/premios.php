<?php

include('conexiones/conec_cookies.php');
include('sec/inc.head.php'); 
include('sec/inc.menu.php');

$cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
$consulta_torneo = mysql_query($cadena, $conn);
$fila = mysql_fetch_assoc($consulta_torneo);

//obterner evento de grupos
$sql_grupos = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=1";
$query_grupos = mysql_query($sql_grupos, $conn);
$row_grupos = mysql_fetch_assoc($query_grupos);

//obtener el evento de llaves
$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=2";
$query_llave = mysql_query($sql_llave, $conn);
$row_llave = mysql_fetch_assoc($query_llave);

$sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=3";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);

$sql_posicion = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] . '  AND t_est_equi.ID_TORNEO=' . $fila['ID'] . ' AND (t_est_equi.POSICION=1 OR t_est_equi.POSICION=2 OR t_est_equi.POSICION=3 OR t_est_equi.POSICION=4 )
				ORDER BY t_est_equi.POSICION ASC LIMIT 0,4';
$query_posicion = mysql_query($sql_posicion, $conn);
$cant = mysql_num_rows($query_posicion);

$sql_m_bat = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] . ' AND t_est_equi.PR_MEN_BATIDO=1 AND t_est_equi.ID_TORNEO=' . $fila['ID'];
$query_m_bat = mysql_query($sql_m_bat, $conn);

$sql_m_ofe = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] . ' AND t_est_equi.PR_MEJ_OFEN=1 AND t_est_equi.ID_TORNEO=' . $fila['ID'];
$query_m_ofe = mysql_query($sql_m_ofe, $conn);

$sql_m_disc = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_grupos['ID'] . ' AND t_est_equi.PR_MAS_DISC=1 AND t_est_equi.ID_TORNEO=' . $fila['ID'];
$query_m_disc = mysql_query($sql_m_disc, $conn);

$sql_recopa = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] . ' AND t_est_equi.PR_CAM_RECOPA=1 AND t_est_equi.ID_TORNEO=' . $fila['ID'];
$query_recopa = mysql_query($sql_recopa, $conn);

$sql_goleador = "SELECT *,(t_personas.NOMBRE)AS NOM_JUG,(t_personas.ID)AS ID_JUG FROM t_est_jug_disc ejd
			LEFT JOIN t_personas ON ejd.ID_PERSONA=t_personas.ID
			WHERE ejd.ID_TORNEO=" . $fila['ID'] . ' AND ejd.PR_GOL=1';
$consulta_goleador = mysql_query($sql_goleador, $conn);

echo '<h1>' . $fila['NOMBRE'] . ' ' . $fila['YEAR'] . '</h1>

<input  class="buton_css" type="button" onclick="document.location.href=\'ingresar_premios.php\'" value="Otorgar Premios">';
echo '<hr/>';
echo'<table class="table_jornadas">
    <tr>
            <td>Poscion</td>
            <td>Equipo</td>
    </tr>
';
$i = 0;
$var_pos = "";
if ($cant != 0) {
    while ($row_posicion = mysql_fetch_assoc($query_posicion)) {
        switch ($i) {
            case 0:
                $var_pos = "Campeon:";
                break;
            case 1:
                $var_pos = "Subcampeon:";
                break;
            case 2:
                $var_pos = "Tercer Lugar:";
                break;
            case 3:
                $var_pos = "Cuarto Lugar:";
                break;
        }
        echo'	
					<tr>
						<td>' . $var_pos . '</td>
						<td>' . $row_posicion['NOMBRE'] . '</td>
					</tr>';
        $i++;
    }
} else {
    echo '
					<tr>
						<td>Campeon:</td>
						<td></td>
					</tr>
					<tr>
						<td>Subcampeon:</td>
						<td></td>
					</tr>
					<tr>
						<td>Tercer Lugar:</td>
						<td></td>
					</tr>
					<tr>
						<td>Cuarto Lugar:</td>
						<td></td>
					</tr>';
}
echo'	</table>
    <br>
	<hr>
        <br>
    <table class="table_jornadas" >
        <tr>
                <td>Premio</td>
                <td>Equipo</td>
        </tr>
				<tr>	
					<td>Arco Menos Batido:</td>
					<td>';
$row_m_bat = mysql_fetch_assoc($query_m_bat);
echo ' ' . $row_m_bat['NOMBRE'] . '</td>
				</tr>
				<tr>
					<td>Mejor Ofensiva:</td>
					<td>';
$row_m_ofe = mysql_fetch_assoc($query_m_ofe);
echo ' ' . $row_m_ofe['NOMBRE'] . ' </td>
				</tr>
				<tr>
					<td>Mas Diciplinado:</td>
					<td>';
$row_m_disc = mysql_fetch_assoc($query_m_disc);
echo ' ' . $row_m_disc['NOMBRE'] . '</td>
				</tr>
			</table>
 <br>
	<hr>
        <br>
			<table class="table_jornadas" >
                        
                        <tr>
                                <td>Premio</td>
                                <td>Jugador</td>
                        </tr>
				<tr>
					<td>Goleador:</td>
					<td>';
$row_goleador = mysql_fetch_assoc($consulta_goleador);
echo ' ' . $row_goleador['NOMBRE'] . ' ' . $row_goleador['APELLIDO1'] . ' ' . $row_goleador['APELLIDO2'] . '</td>
				</tr>
			</table>
 <br>
	<hr>
        <br>
			<table class="table_jornadas" >
                        <tr>
                                <td>Premio</td>
                                <td>Jugador</td>
                        </tr>
				<tr>
					<td>Campeon ' . $row['NOMBRE'] . ':</td>
					<td>';
$row_recopa = mysql_fetch_assoc($query_recopa);
echo ' ' . $row_recopa['NOMBRE'] . ' </td>
				</tr>
			</table>
	';
?>
<?php

include('sec/inc.footer.php');
?>
