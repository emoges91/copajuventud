<?php
include 'inc.head.php';


$pg = $_GET['pg'];

if (!isset($pg)) {
    $pg = 0; // $pg es la pagina actual
}
$cantidad = 9; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_img WHERE ALBUN = '" . $_GET['ID'] . "' ORDER BY ID LIMIT $inicial,$cantidad";
$cad = mysql_db_query($bd, $pegar) or die(mysql_error());

$contar = "SELECT * FROM t_img WHERE ALBUN = '" . $_GET['ID'] . "' ORDER BY ID";
$contarok = mysql_db_query($bd, $contar);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
?>
<div class="container ">
    <h1>Album de fotos</h1>
    <hr/>
    <?php
    if ($total_records > 0) {
        $sql = "SELECT * FROM t_albun WHERE ID='" . $_GET['ID'] . "'";
        $query = mysql_db_query($bd, $sql);
        $row1 = mysql_fetch_assoc($query);
        echo '

            <h2>' . $row1['NOMBRE'] . '</h2>
            <p >' . $row1['DESCRIP'] . '</p>
            <h5 >' . $row1['FEC_CRE'] . ' - ' . $row1['FEC_MOD'] . '</h5>
            <hr/>
			';

        while ($row = mysql_fetch_assoc($cad)) {

            echo '
			<div class="box_foto"> 
				<a href="admin/' . $row['URL'] . '" rel="prettyPhoto[pp_gal]" title="' . $row['DESCRIP'] . '">
                                    <img src="admin/' . $row['URL_THUMB300'] . '" alt="' . $row['NOMBRE'] . '" />
                                </a>
                                <p><b> ' . $row['NOMBRE'] . '<b></p>
                            <p >' . $row['DESCRIP'] . '</p>
                            
			</div>	
			';
        }
    } else {
        echo '<p>No hay fotos en este albun</p>';
    }

// Cerramos la conexión a la base
    $conn = mysql_close($conn);


// Creando los enlaces de paginación
       echo '<div class="paginate">';
    if ($pg != 0) {
        $url = $pg - 1;
        echo '<a href="album_detalle.php?ID=' . $_GET['ID'] . '&pg=' . $url . '&ida=' . $_GET['ID'] . '&pgpa=' . $_GET['pgpa'] . '" class="hiper">&laquo; Anterior</a>&nbsp;';
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
                echo '<a href="album_detalle.php?ID=' . $_GET['ID'] . '&pg=' . $i . '&ida=' . $_GET['ID'] . '&pgpa=' . $_GET['pgpa'] . '" class="hiper">1</a> ';
            } else {
                echo '<a href="album_detalle.php?ID=' . $_GET['ID'] . '&pg=' . $i . '&ida=' . $_GET['ID'] . '&pgpa=' . $_GET['pgpa'] . '" class="hiper">';
                $j = $i + 1;
                echo $j . "</a> ";
            }
        }
    }
    if ($pg < $pages) {
        $url = $pg + 1;
        echo '<a href="album_detalle.php?ID=' . $_GET['ID'] . '&pg=' . $url . '&ida=' . $_GET['ID'] . '&pgpa=' . $_GET['pgpa'] . '" class="hiper">Siguiente &raquo; </a>';
    }
     echo "</div>";

    ?>
    <div id="fb-root" align="center"></div>
    <script src="http://connect.facebook.net/en_US/all.js#appId=APP_ID&amp;xfbml=1"></script>
    <fb:comments numposts="10" width="700" publish_feed="true"></fb:comments>
    <script src="http://connect.facebook.net/en_US/all.js#appId=264887889270&amp;xfbml=1"></script>
</div>

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
include 'inc.footer.php';
?>