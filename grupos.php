<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

$cadena = "SELECT * FROM t_torneo  WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena);
$fila = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

include 'inc.menu_tor.php';
?>
<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Grupos</h1>
    <hr/>

    <?php
    if ($cant_tor > 0) {

        $cadena_equi = "
                 SELECT 
                    j.`ID`, 
                    j.`ID_EQUI_CAS`, 
                    j.`ID_EQUI_VIS`, 
                    j.`FECHA`, 
                    j.`ESTADO`, 
                    j.`NUM_JOR`, 
                    j.`ID_EVE`, 
                    j.`GRUPO`, 
                    IF(j.`MARCADOR_CASA` is NULL,'-',j.`MARCADOR_CASA`) as MAR_CASA, 
                    IF(j.`MARCADOR_VISITA` is NULL,'-',j.`MARCADOR_VISITA`) as MAR_VISITA, 
                    IF(e1.NOMBRE is null,'Libre',e1.NOMBRE)as NOM_CASA,
                    IF(e2.NOMBRE is null,'Libre',e2.NOMBRE)as NOM_VISITA ,
                    pj.CANCHA,
                    pj.HORA,
                    ev.ID as ID_EVENTO,
                    ev.NOMBRE as NOM_EVE,
                    t.NOMBRE,
                    tjs.TJS_NOMBRE 
                FROM t_jornadas j
            LEFT JOIN t_prox_jor pj ON j.ID = pj.ID_JOR
            LEFT JOIN t_equipo e1 ON j.ID_EQUI_CAS = e1.ID
            LEFT JOIN t_equipo e2 ON j.ID_EQUI_VIS = e2.ID
            RIGHT JOIN t_eventos ev ON j.ID_EVE= ev.ID
            RIGHT JOIN t_torneo t ON ev.ID_TORNEO= t.ID
            LEFT JOIN t_jornadas_state tjs ON j.ESTADO = tjs.TJS_ID
            WHERE 
            t.ID=" . $sTorneoID . "
            AND ev.TIPO =1
            ORDER BY ev.ID,j.`NUM_JOR` ASC,j.`GRUPO` ASC,j.`ID`";
        $consulta_total_grupos = mysql_query($cadena_equi, $conn);
        $cant_jor = mysql_num_rows($consulta_total_grupos);

        if ($cant_jor > 0) {
            $nJor = '0';
            while ($total_grupos = mysql_fetch_assoc($consulta_total_grupos)) {

                $dFechaPartido = '';
                if ($total_grupos['FECHA'] != 1) {
                    $dFechaPartido = cambiaf_a_normal($total_grupos['FECHA']);
                }


                if ($nJor != $total_grupos['NUM_JOR'] && $nJor != '0') {
                    echo ' </table>';
                }
                if ($nJor != $total_grupos['NUM_JOR']) {
                    echo "
                    <table class='table1'>    
                    <tr >
                        <th colspan='6'>Jornada " . $total_grupos['NUM_JOR'] . "</th>
                        <th></th>
                    </tr>
                    <tr id='titulo'>
                            <td >&ensp;Equipo Casa&ensp;</td>
                            <td >&ensp;Marcador&ensp;</td>
                            <td >&ensp;Equipo visita&ensp;</td>
                            <td >&ensp;Marcador&ensp;</td>
                            <td >&ensp;Fecha&ensp;</td>
                            <td >&ensp;Estado&ensp;</td>
                            <td >&ensp;Grupo&ensp;</td>
                    </tr>";
                }

                //---------------mostrar jornadas----------------		
                echo '<tr  id="cuerpo">
                            <td >' . $total_grupos['NOM_CASA'] . '</td>
                            <td >' . $total_grupos['MAR_CASA'] . '</td>
                            <td >' . $total_grupos['NOM_VISITA'] . '</td>
                            <td >' . $total_grupos['MAR_VISITA'] . '</td>
                            <td >' . $dFechaPartido . '</td>
                            <td >' . $total_grupos['TJS_NOMBRE'] . '</td>
                            <td >' . $total_grupos['GRUPO'] . '</td>
                    </tr>';


                if ($nJor != $total_grupos['NUM_JOR']) {
                     $nJor = $total_grupos['NUM_JOR'];
                }
            }
            echo ' </table>';
        } else {
            ?>
            <h3>Las jornadas del campeonato no se encuentran registradas</h3>
            <?php
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