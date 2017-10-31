<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$fila_torneo = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);

$sql = "
    SELECT 
    * 
    FROM t_equipo 
    WHERE 
    ID = '" . $_GET['id_equi'] . "'";
$query = mysql_query($sql, $conn) or die(mysql_error());

include 'inc.menu_tor.php';
?>

<div class="container ">
    <h1><?php echo $fila_torneo['NOMBRE'] . ' ' . $fila_torneo['YEAR']; ?> - Equipos</h1>
    <hr/>
    <?php
    if ($fila = mysql_fetch_assoc($query)) {
        ?>
        <div class="equipo_detail">
            <img class="left" src="<?php echo 'admin/' . $fila['url']; ?>" >
            <div class="left">
                <h3><?php echo $fila['NOMBRE']; ?></h3>
                <p class="border_boton_grey">
                    Cancha oficial: 
                    <?php
                    $cadena = "SELECT * FROM t_cancha WHERE ID = '" . $fila['CAN_OFI'] . "'";
                    $consulta = mysql_query($cadena, $conn) or die(mysql_error());
                    $datos = mysql_fetch_assoc($consulta);

                    echo $datos['NOMBRE'];
                    ?>
                </p>
                <p class="border_boton_grey">
                    Cancha alterna:
                    <?php
                    $cadena = "SELECT * FROM t_cancha WHERE ID = '" . $fila['CAN_ALT'] . "'";
                    $consulta = mysql_query($cadena, $conn) or die(mysql_error());
                    $datos = mysql_fetch_assoc($consulta);

                    echo $datos['NOMBRE'];
                    ?>
                </p>
<!--                <p>
                    <a  href="historial_equi.php?id_equi=<?php echo $_GET['id_equi']; ?>" >Historial</a>
                </p>-->
            </div>
            <div class="clear"></div>
        </div>
        <?php
        /*         * prueba* */

        $sql = "
            SELECT 
                *,
                (t_personas.ID)AS IDP 
            FROM t_personas 
            LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA 
            WHERE 
                t_personas.ID_EQUI = " . $_GET['id_equi'] . " 
                AND t_car_per.CARGO='Jugador'";
        $query = mysql_query($sql, $conn);
        $cant = mysql_num_rows($query);
        ?>
        <h3>Jugadores</h3>
        <table class="table1">
            <tr id="titulo" >
                <th ><b></b></th>
                <th ><b>Nombre</b></th>
                <th colspan="2"><b>Apellidos</b></th>
                <th></th>
            </tr>
            <?php
            if ($cant > 0) {
                $numero = 0;

                while ($row = mysql_fetch_assoc($query)) {
                    $numero++;
                    if ($row['ACTIVO'] = 1) {
                        echo '
                            <tr>
                                <td>' . $numero . '</td>
                                <td align="center"> ' . htmlentities($row['NOMBRE']) . '</td>
                                <td align="center"> ' . htmlentities($row['APELLIDO1']) . '</td>
                                <td align="center"> ' . htmlentities($row['APELLIDO2']) . '</td>
                                <td align="center"> 
                                    <a href="jugador.php?tor=' . $sTorneoID . '&id=' . $row['IDP'] . '&id_equi=' . $_GET['id_equi'] . '">Ver</a>
                                </td>
                            </tr>';
                    }
                }
            } else {
                echo '
                    <tr>
                            <td colspan="4">No hay jugadores registrados</td>
                    </tr>';
            }
            ?>

        </table>

        <?php
        $sql = "
            SELECT 
            * 
            FROM t_personas 
            LEFT JOIN t_car_per ON t_personas.ID=t_car_per.ID_PERSONA
            WHERE 
                t_personas.ID_EQUI = " . $_GET['id_equi'] . " 
                AND (t_car_per.CARGO='Director Tecnico' or t_car_per.CARGO='Asistente' or t_car_per.CARGO='Representante' or t_car_per.CARGO='Suplente')";
        $query = mysql_query($sql, $conn);
        $cant = mysql_num_rows($query);
        ?>
        <h3>Cuerpo Tecnico</h3>

        <table  class="table1"> 
            <tr id="titulo" >
                <th><b></b></th>
                <th ><b>Nombre</b></th>
                <th colspan="2"><b>Apellidos</b></th>
                <th  colspan="2"><b>Cargo</b></th>
            </tr>
            <?php
            $numero = 0;
            if ($cant > 0) {
                while ($row = mysql_fetch_assoc($query)) {
                    echo '
                        <tr >
                            <td>' . ($numero = $numero + 1) . '</td>
                            <td >' . $row['NOMBRE'] . '</td>
                            <td >' . $row['APELLIDO1'] . '</td>
                            <td >' . $row['APELLIDO2'] . '</td>
                            <td >' . $row['CARGO'] . '</td>
                        </tr>';
                }
            } else {
                echo '
                         <tr >
                            <td colspan="4" >No inscrito</td>
                         </tr>';
            }
            ?>	
        </table>
        <?php
    } else {
        echo '
    		<h3>No hay personas registradas a este equipo</h3>';
    }
    ?>

</div>
<?php
include 'inc.footer.php';
?>