<?php
include 'inc.head.php';
?>
<div class="container ">
    <h1>Videos</h1>
    <hr/>
    <?php
    $pg = $_GET['pg'];

    if (!isset($pg)) {
        $pg = 0; // $pg es la pagina actual
    }
    $cantidad = 6; // cantidad de resultados por página
    $inicial = $pg * $cantidad;

    $pegar = "SELECT * FROM t_video ORDER BY ID DESC LIMIT $inicial,$cantidad";
    $cad = mysql_db_query($bd, $pegar) or die(mysql_error());

    $contar = "SELECT * FROM t_video ORDER BY ID DESC";
    $contarok = mysql_db_query($bd, $contar);
    $total_records = mysql_num_rows($contarok);
    $pages = intval($total_records / $cantidad);
    ?>

    <?php
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
                                           
                </div>';
            $total = $total + 1;
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
        echo '<a href="videos.php?pg=' . $url . '" class="hiper">&laquo; Anterior</a>&nbsp;';
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
                echo '<a href="videos.php?pg=' . $i . '" class="hiper">1</a> ';
            } else {
                echo '<a href="videos.php?pg=' . $i . '" class="hiper">';
                $j = $i + 1;
                echo $j . "</a> ";
            }
        }
    }
    if ($pg < $pages) {
        $url = $pg + 1;
        echo '<a href="videos.php?pg=' . $url . '" class="hiper">Siguiente &raquo; </a>';
    }
   echo "</div>";
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
</div>
<?php
include 'inc.footer.php';
?>