<?php
include('conexiones/conec.php');

$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;

$total = 2;
$cantidad = 12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_video ORDER BY ID DESC LIMIT $inicial,$cantidad";
$cad = mysql_query($pegar);

$contar = "SELECT * FROM t_video ORDER BY ID DESC";
$contarok = mysql_query($contar);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);

include('sec/inc.head.php');
?>

<h1>Videos</h1> 
<hr/>
<br/>
<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'video_add.php ';" value="Agregar"/> 
</div>
<div class="clear"></div>
<br/>
<div class="">
    <?php
// Imprimiendo los resultados
    if ($total_records > 0) {
        while ($row = mysql_fetch_assoc($cad)) {

            echo '
                <div class="album_box"> 
                    <a href="' . $row['URL'] . '" rel="prettyPhoto[pp_gal]" title="' . $row['DESCRIP'] . '">
                        <img src="' . $row['URLI'] . '"  alt="' . $row['NOMBRE'] . '" />
                    </a>
                    <h3> ' . $row['NOMBRE'] . '</h3>
                    <p>' . $row['DESCRIP'] . '</p>
                    <h5>' . $row['FEC_PUBL'] . '</h5>
                    <p>
                        <a href="video_detalle.php?ID=' . $row['ID'] . '">Editar</a>  
                            || 
                        <a href="video_delete.php?ID=' . $row['ID'] . '"onclick="javascript: return sure();">Eliminar</a>
                    </p>  
                </div>';
        }
        ?>
    </div>
    <?php
} else {
    echo '<p>No hay videos</p>';
}

echo '<h2 class="align_center">';
if ($pg != 0) {
    $url = $pg - 1;
    echo '<a href="videos.php?&pg=' . $url . '">&laquo; Anterior</a>&nbsp;';
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
            echo '<a href="videos.php?&pg=' . $i . '">1</a> ';
        } else {
            echo '<a href="videos.php?&pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo '<a href="videos.php?&pg=' . $url . '">Siguiente &raquo; </a>';
}
echo "</h2>";
?>
<?php
include('sec/inc.footer.php');
?>