<?php
include 'inc.head.php';
?>
<?php
$pg = $_GET['pg'];

if (!isset($pg)) {
    $pg = 0; // $pg es la pagina actual
}
$cantidad = 6; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_albun ORDER BY ID DESC LIMIT $inicial,$cantidad";
$cad = mysql_db_query($bd, $pegar) or die(mysql_error());

$contar = "SELECT * FROM t_albun ORDER BY ID DESC";
$contarok = mysql_db_query($bd, $contar);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
?>
<div class="container ">
    <h1>Albumes de fotos</h1>
    <hr/>

    <?php
// Imprimiendo los resultados
    if ($total_records > 0) {
        while ($row = mysql_fetch_assoc($cad)) {
            $sql2 = "SELECT * FROM t_img WHERE ID='" . $row['PORTADA'] . "'";
            $que2 = mysql_query($sql2, $conn);
            $row2 = mysql_fetch_assoc($que2);
            $sqlconta = "SELECT * FROM t_img WHERE ALBUN='" . $row['ID'] . "'";
            $queconta = mysql_query($sqlconta, $conn);
            $total_img = mysql_num_rows($queconta);

            echo'
		
			<div class="album_box">
                        <a href="visitas.php?ID=' . $row['ID'] . '&ida=' . $pg . '">
                            <img src="admin/' . $row2['URL_THUMB300'] . '">
                        </a>
                        <a href="visitas.php?ID=' . $row['ID'] . '&ida=' . $pg . '"><h3>' . $row['NOMBRE'] . ' - ' . $total_img . '</h3></a>
                              
                        <p> ' . $row['DESCRIP'] . '</p>
                        <h5>' . $row['FEC_CRE'] . ' - Visitas: ' . $row['VISITAS'] . '</h5>
                       </div>
                        ';
        }
    } else {
        echo '<P>No hay albunes</P>';
    }
// Cerramos la conexión a la base
    $conn = mysql_close($conn);

// Creando los enlaces de paginación
    echo '<div class="paginate">';
    if ($pg != 0) {
        $url = $pg - 1;
        echo '<a href="imagenes.php?pg=' . $url . '">&laquo; Anterior</a>&nbsp;';
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
                echo '<a href="imagenes.php?pg=' . $i . '">1</a> ';
            } else {
                echo '<a href="imagenes.php?pg=' . $i . '">';
                $j = $i + 1;
                echo $j . "</a> ";
            }
        }
    }
    if ($pg < $pages) {
        $url = $pg + 1;
        echo '<a href="imagenes.php?pg=' . $url . '">Siguiente &raquo; </a>';
    }
    echo "</div>";
    ?>
</div>
<?php
include 'inc.footer.php';
?>