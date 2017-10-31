<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

$cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
$consulta_torneo = mysql_query($cadena, $conn);
$fila = mysql_fetch_assoc($consulta_torneo);
$cant_tor = mysql_num_rows($consulta_torneo);
?>

<div class="container ">
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Equipos</h1>
    <hr/>

    <?php
    if ($cant_tor > 0) {
        $sql = "
            SELECT 
                *,
                (e.ID)AS ID_EQUI,
                (e.NOMBRE) as EQUI_NOMBRE
            FROM t_even_equip eeq
            LEFT JOIN t_equipo e ON eeq.ID_EQUI=e.ID
            LEFT JOIN t_eventos ev ON eeq.ID_EVEN=ev.ID
            WHERE 
                ev.ID_TORNEO=" . $fila['ID'] . " and ev.TIPO=1";
        $query = mysql_query($sql, $conn);
        $cant = mysql_num_rows($query);

        if ($cant > 0) {

            while ($row = mysql_fetch_assoc($query)) {
                echo'
                    <div class="equipo_box">
                         <a href="equipo_ver.php?tor=' . $sTorneoID . '&id_equi=' . $row['ID_EQUI'] . '" id="links">
                        <img src="admin/' . $row['url'] . '" >
                        </a>
                        <a href="equipo_ver.php?tor=' . $sTorneoID . '&id_equi=' . $row['ID_EQUI'] . '" class="hiper">
                            <h3> ' . $row['EQUI_NOMBRE'] . ' </h3>
                        </a>
                    </div>';
            }
        } else {
            ?>
            <h3>No hay datos que mostrar</h3>
            <?php
        }
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