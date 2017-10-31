<?php
include("conexiones/conec_cookies.php");
$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
$sSearchName = (isset($_POST['search_name'])) ? $_POST['search_name'] : '';

$cantidad = 12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sNombre = '';
if (trim($sSearchName) != '') {
    $sNombre = "WHERE e.NOMBRE like '" . $sSearchName . "%'";
}

$sSql = "
    SELECT 
    *,
    (co.NOMBRE) CO_NOMBRE,
    (ca.NOMBRE) CA_NOMBRE,
    (e.NOMBRE) EQUI_NOMBRE,
    (e.ID) as E_ID
    FROM t_equipo  e
    LEFT JOIN t_cancha co ON e.CAN_OFI=co.ID
    LEFT JOIN t_cancha ca ON e.CAN_ALT=ca.ID
    " . $sNombre . "  
    ORDER BY e.NOMBRE     
";
$oQuery = mysql_query($sSql, $conn);
$nCant = mysql_num_rows($oQuery);

$contar = "SELECT 
    *,
    (co.NOMBRE) CO_NOMBRE,
    (ca.NOMBRE) CA_NOMBRE,
    (e.NOMBRE) EQUI_NOMBRE,
    (e.ID) as E_ID
    FROM t_equipo  e
    LEFT JOIN t_cancha co ON e.CAN_OFI=co.ID
    LEFT JOIN t_cancha ca ON e.CAN_ALT=ca.ID
    " . $sNombre . "  
    ORDER BY e.NOMBRE 
    LIMIT $inicial,$cantidad";
$contarok = mysql_query($contar, $conn); //mismo error q en la linea 29
$total_records = mysql_num_rows($contarok);
$pages = intval($nCant / $cantidad);

include('sec/inc.head.php'); 
?>
<h1>Equipos</h1>
<form action="" method="post" style="float:left; margin-right: 10px;"> 
    <input type="text" name="search_name" value="<?php echo $sSearchName; ?>"/>
    <input type="submit" name="" value="Buscar" class="buton_css"/>
</form>
<a class="buton_css" href="./equipos_agregar.php">Agregar</a>
<div class="clear"></div>
<hr>
<table width="100%" class="table_content">
    <tr>
        <td>
            Escudo
        </td>
        <td>
            Nombre
        </td>
        <td>Oficial</td>
        <td>Alterna</td>
        <td>Acciones</td>
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
                    </td>
                    <td> <p>' . $row['EQUI_NOMBRE'] . '</p>  </td>
                    <td>' . $row['CO_NOMBRE'] . '</td>
                    <td>' . $row['CA_NOMBRE'] . '</td>
                    <td>
                        <a href="editar_equipo.php?id=' . $row['E_ID'] . '">Editar</a>
                            ||
                        <a href="equipo_historial.php?id=' . $row['E_ID'] . '">Historial</a>
                            ||
                        <a href="eliminar_equipos_permantes.php?ID=' . $row['E_ID'] . '" onclick="javascript: return sure();">Eliminar</a>
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
    echo '<a href="equipos.php?pg=' . $url . '">&laquo; Anterior </a>';
} 
for ($i = 0; $i <= $pages; $i++) {
    if ($i == $pg) {
        if ($i == "0") {
            echo "<b> 1 </b>";
        } else {
            $j = $i + 1;
            echo "<b> " . $j . " </b>";
        }
    } else {
        if ($i == "0") {
            echo '<a href="equipos.php?pg=' . $i . '">1</a> ';
        } else {
            echo '<a href="equipos.php?pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo '<a href="equipos.php?pg=' . $url . '"> Siguiente &raquo; </a>';
}
echo "</h2>";
?>
<?php
include('sec/inc.footer.php');
?>