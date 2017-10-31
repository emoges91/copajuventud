<?php
include('conexiones/conec_cookies.php');

$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
$sSearchName = (isset($_POST['search_name'])) ? $_POST['search_name'] : '';

$cantidad = 20; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sNombre = '';
if (trim($sSearchName) != '') {
    $sNombre = "WHERE NOMBRE like '" . $sSearchName . "%'";
}
$sSql = "
    SELECT 
    * 
    FROM t_personas 
    " . $sNombre . " 
    ORDER BY APELLIDO1 ASC";
$oQuery = mysql_query($sSql, $conn);
$nCant = mysql_num_rows($oQuery);

$sql = "
    SELECT 
    * 
    FROM t_personas 
    " . $sNombre . " 
    ORDER BY APELLIDO1 
    LIMIT $inicial,$cantidad";

$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
$pages = intval($nCant / $cantidad);

include('sec/inc.head.php'); 
?>
<h1>Personas</h1>
<form action="" method="post" style="float:left; margin-right: 10px;"> 
    <input type="text" name="search_name" value="<?php echo $sSearchName; ?>"/>
    <input type="submit" name="" value="Buscar" class="buton_css"/>
</form>
<a class="buton_css" href="./personas_add.php">Agregar</a>
<div class="clear"></div>
<hr>
<table  width="100%" class="table_content"> 
    <tr>
        <td><b>Acciones</b> </td>
        <td ><b>Cedula</b></td>
        <td ><b>Nombre</b></td>
        <td ><b>Primer apellido</b></td>
        <td ><b>Segundo apellido</b></td>
        <td ><b>Telefono</b></td>
    </tr>
    <?php
    $numero = 0;
    if ($cant > 0) {
        while ($row = mysql_fetch_assoc($query)) {
            echo '
                <tr>
                    <td>
                        <a href="editar_jugador.php?id=' . $row['ID'] . '">Editar</a>
                        ||    
                        <a href="eliminar_persona.php?ID=' . $row['ID'] . '" onclick="javascript: return sure();">Eliminar</a>
                    </td>
                    <td>' . $row['CED'] . '</td>
                    <td>' . $row['NOMBRE'] . '</td>
                    <td>' . $row['APELLIDO1'] . '</td>
                    <td>' . $row['APELLIDO2'] . '</td>
                    <td>' . $row['TEL'] . '</td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="7">No hay jugadores disponibles</td></tr>';
    }
    ?> 
</table>

<?php
echo '<h2>';
if ($pg != 0) {
    $url = $pg - 1;
    echo '<a href="personas.php?pg=' . $url . '">&laquo; Anterior </a>';
} else {
    echo " ";
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
            echo '<a href="personas.php?pg=' . $i . '">1</a> ';
        } else {
            echo '<a href="personas.php?pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo '<a href="personas.php?pg=' . $url . '"> Siguiente &raquo; </a>';
}
echo "</h2>";


include('sec/inc.footer.php');
?>
