<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$fila_torneo = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

include 'inc.menu_tor.php';
?>

<div class="container ">
    <h1><?php echo $fila_torneo['NOMBRE'] . ' ' . $fila_torneo['YEAR']; ?> - Tabla de goleadores</h1>
    <hr/>

    <?php
    if ($cant_tor > 0) {
        $sql_goleador = "SELECT 
                                *,(e.NOMBRE)AS NOM_EQUI,(p.NOMBRE)AS NOM_JUG 
                         FROM t_est_jug tej
                        LEFT JOIN t_personas p ON tej.ID_PERSONA=p.ID
                        LEFT JOIN t_equipo e ON tej.ID_EQUI=e.ID
                        WHERE tej.ID_TORNEO=" . $fila_torneo['ID'] .' 
                        ORDER BY tej.GOLANO DESC LIMIT 0,15';
        $consulta_goleador = mysql_query($sql_goleador, $conn);

        echo'<table class="table1">
                <tr id="titulo" >
                        <th>Pos.</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Equipo</th>
                        <th>Goles</th>
                </tr>';
        $contador = 1;
        while ($fila_goleador = mysql_fetch_assoc($consulta_goleador)) {
     
            echo'
                <tr  id="cuerpo">
                        <td>' . $contador . '</td>
                        <td align="center">' . htmlentities($fila_goleador['NOM_JUG']) . '</td>
                        <td align="center">' . htmlentities($fila_goleador['APELLIDO1']) . '</td>
                        <td align="center">' . htmlentities($fila_goleador['APELLIDO2']) . '</td>
                        <td align="center">' . htmlentities($fila_goleador['NOM_EQUI']) . '</td>
                        <td align="center">' . $fila_goleador['GOLANO'] . '</td>
                </tr>';
            $contador++;
        }
        echo '</table>';
    } else {
        ?>
        <h3>El torneo no se encuentra registrado</h3>
        <?php
    }
    ?>
</div>
<?php
include 'inc.footer.php';
?>