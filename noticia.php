<?php
include 'inc.head.php';
?>
<?php
$pg = (isset($_GET['pg']) ? $_GET['pg'] : '0');
$cantidad = 6; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_noticias ORDER BY ID DESC LIMIT $inicial,$cantidad";
$cad = mysql_db_query($bd, $pegar) or die(mysql_error());

$contar = "SELECT * FROM t_noticias ORDER BY ID DESC";
$contarok = mysql_db_query($bd, $contar);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
?>

<div class="container ">
    <h1>Noticias</h1>
    <hr/>
    <div class="notice_container">
        <?php
        if ($total_records > 0) {
            while ($row = mysql_fetch_assoc($cad)) {
                ?>
                <div class="notice_box">
                    <?php
                    echo '			
                <a href="noticia_detalle.php?id=' . $row['ID'] . '&pg=' . $pg . '">
                    <img src="admin/noticias/' . $row['URL_IMAGEN'] . '" class="height mibloque"  align="center">
                </a>
                <a href="index.php?pag=detalle_noticia.php&id=' . $row['ID'] . '&pg=' . $pg . '">
                    <h3>' . $row['TITULO'] . '</h3>
                </a>
                <h5>' . $row['FECHA'] . '</h5>
                <div class="desc">' . substr($row['DESCRIPCION_CORTA'], 0, 79) . '... <a href="noticia_detalle.php?id=' . $row['ID'] . '&pg=' . $pg . '">Leer Mas</a></div>
                ';
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        echo '<p>No hay noticias publicadas</p>';
    }
// Cerramos la conexión a la base
    $conn = mysql_close($conn);

// Creando los enlaces de paginación
    echo '<div class="paginate">';
    if ($pg != 0) {
        $url = $pg - 1;
        echo '<a href="noticia.php?pg=' . $url . '" class="hiper">&laquo; Anterior</a>&nbsp;';
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
                echo '<a href="noticia.php?pg=' . $i . '" >1</a> ';
            } else {
                echo '<a href="noticia.php?pg=' . $i . '" >';
                $j = $i + 1;
                echo $j . "</a> ";
            }
        }
    }
    if ($pg < $pages) {
        $url = $pg + 1;
        echo '<a href="noticia.php?pg=' . $url . '" class="hiper">Siguiente &raquo; </a>';
    }
    echo "</div>";
    ?>
</div>
<?php
include 'inc.footer.php';
?>