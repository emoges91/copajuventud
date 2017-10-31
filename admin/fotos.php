<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;

$total = 0;

$cantidad = 18; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_img  WHERE ALBUN = '" . $_GET['ID'] . "' ORDER BY ID LIMIT $inicial,$cantidad";
$cad = mysql_query($pegar, $conn) or die(mysql_error());

$contar = "SELECT * FROM t_img   WHERE ALBUN = '" . $_GET['ID'] . "' ORDER BY ID";
$contarok = mysql_query($contar, $conn);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);

$sql = "SELECT * FROM t_albun WHERE ID = " . $_GET['ID'] . "";
$query = mysql_query($sql, $conn) or die(mysql_error());
$dato = mysql_fetch_assoc($query);
?>
<h1>Fotos del album</h1>
<h2><?php echo $dato['NOMBRE']; ?></h2>
<hr/>
<br/>
<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'foto_add.php?ID=<?php echo $_GET['ID']; ?>';" value="Agregar Foto"/> 
</div>
<div class="clear"></div>
<br/> 
<?php
// Imprimiendo los resultados
if ($total_records > 0) {
    while ($row = mysql_fetch_assoc($cad)) {
        echo '
            <div class="album_box"> 
                <a href="fotos.php?ID=' . $row['ID'] . '" title="' . $row['DESCRIP'] . '">
                    <img src="' . $row['URL'] . '"  alt="' . $row['NOMBRE'] . '" />
                </a>
                <h3> ' . $row['NOMBRE'] . '</h3>
                <p>' . $row['DESCRIP'] . '</p>
                <h5>' . $row['FEC_CRE'] . '</h5>
                <p>
                    <a href="foto_edit.php?ID=' . $row['ID'] . '&IDA=' . $_GET['ID'] . '&pg=' . $pg . '">
                        Editar
                    </a> 
                    ||
                    <a href="foto_delete.php?id=' . $row['ID'] . '&idp=' . $_GET['ID'] . '&pg=' . $pg . '"onclick="javascript: return sure();">
                        Eliminar
                    </a>	
                </p>  
            </div>';
    }
} else {
    echo '<h2>No hay fotos en este album</h2>';
}


// Creando los enlaces de paginación
echo '<h2 class="align_center">';
if ($pg != 0) {
    $url = $pg - 1;
    echo '<a href="fotos.php?ID=' . $_GET['ID'] . '&pg=' . $url . '">&laquo; Anterior</a>&nbsp;';
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
            echo '<a href="fotos.php?ID=' . $_GET['ID'] . '&pg=' . $i . '">1</a> ';
        } else {
            echo '<a href="fotos.php?ID=' . $_GET['ID'] . '&pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo '<a href="fotos.php?ID=' . $_GET['ID'] . '&pg=' . $url . '">Siguiente &raquo; </a>';
}
echo "</h2>";
?>
<script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $(".gallery a[rel^='prettyPhoto']").prettyPhoto({animationSpeed: 'slow', theme: 'dark_rounded', slideshow: 5000});

            $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
                custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
                changepicturecallback: function() {
                    initialize();
                }
            });

            $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
                custom_markup: '<div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
                changepicturecallback: function() {
                    _bsap.exec();
                }
            });
        });
</script> 		


<?php
include('sec/inc.footer.php');
?>
