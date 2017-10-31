<?php
include("conexiones/conec_cookies.php");
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/equipos/equipos.php';

$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
$sSearchName = (isset($_POST['search_name'])) ? $_POST['search_name'] : '';

$oTorneo = new torneo();
$oEquipos = new equipos();

$fila = $oTorneo->getTorneoByID($sTorVerID);


$cantidad = 12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sNombre = '';
if (trim($sSearchName) != '') {
    $sNombre = " AND eq.NOMBRE like '" . $sSearchName . "%'";
}

$contar = "
     select 
          DISTINCT  
        eq.ID as EQ_ID,
        eq.url,
        eq.NOMBRE as EQ_NOMBRE, 
        eq.ACTIVO as EQ_ACTIVO, 
        eq.CAN_OFI as EQ_OFI, 
        eq.CAN_ALT as EQ_ALT, 
        eq.url as EQ_URL,
        (co.NOMBRE) CO_NOMBRE,
        (ca.NOMBRE) CA_NOMBRE
    from t_equipo eq
    LEFT JOIN t_even_equip ee on eq.id =ee.ID_EQUI
    LEFT JOIN t_eventos e on e.id =ee.ID_EVEN
    LEFT JOIN t_cancha co ON eq.CAN_OFI=co.ID
    LEFT JOIN t_cancha ca ON eq.CAN_ALT=ca.ID
    WHERE
        e.ID_TORNEO='" . $sTorVerID . "' 
        " . $sNombre . "
    ORDER BY 
        eq.NOMBRE 
    LIMIT $inicial,$cantidad";
$contarok = mysql_query($contar); //mismo error q en la linea 29
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR'] ?></h1>
<h2>Equipos</h2>
<form action="" method="post" style="float:left; margin-right: 10px;"> 
    <input type="text" name="search_name" value="<?php echo $sSearchName; ?>"/>
    <input type="submit" name="" value="Buscar" class="buton_css"/>
</form>
<div class="clear"></div>
<hr>
<table width="100%" class="table_content">
    <tr>
        <td>Escudo</td>
        <td>Nombre</td>
        <td>Oficial</td>
        <td>Alterna</td>
        <td></td>
    </tr>
    <?php
    if ($total_records > 0) {
        while ($row = mysql_fetch_assoc($contarok)) {
            if (trim($row['url']) == '') {
                $row['url'] = 'images/no_image.png';
            }
            echo'
                <tr>
                    <td>
                        <img src="' . $row['url'] . '" width="32px" border="0" style="margin-right:12px;">
                        <div class="clear"></div>
                    </td>
                    <td> <p>' . $row['EQ_NOMBRE'] . '</p> </td>
                    <td>' . $row['CO_NOMBRE'] . '</td>
                    <td>' . $row['CA_NOMBRE'] . '</td>
                    <td>
                        <a href="torneo_equipo_detalle.php?id=' . $row['EQ_ID'] . '">Ver</a>
                    </td>
                </tr>';
        }
        ?>
    </table>
    <?php
} else {
    echo '<p>No hay datos que mostrar</p>';
}
// Cerramos la conexión a la base
$conn = mysql_close($conn);

// Creando los enlaces de paginación
echo '<h2>';
if ($pg != 0) {
    $url = $pg - 1;
    echo '<a href="torneo_equipos.php?pg=' . $url . '">&laquo; Anterior</a>';
} else {
    echo " ";
}
for ($i = 0; $i <= $pages; $i++) {
    if ($i == $pg) {
        if ($i == "0") {
            echo " <b> 1 </b>";
        } else {
            $j = $i + 1;
            echo " <b> " . $j . " </b>";
        }
    } else {
        if ($i == "0") {
            echo ' <a href="torneo_equipos.php?pg=' . $i . '">1</a> ';
        } else {
            echo ' <a href="torneo_equipos.php?pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo ' <a href="torneo_equipos.php?pg=' . $url . '">Siguiente &raquo; </a>';
}
echo "</h2>";
?>
<?php
include('sec/inc.footer.php');
?>