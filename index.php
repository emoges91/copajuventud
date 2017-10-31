<?php
include 'inc.head.php';

$sql = "SELECT * FROM t_noticias ORDER BY ID DESC LIMIT 0,4";
$query = mysql_query($sql, $conn);
$aMainNoti = array();
while ($row = mysql_fetch_assoc($query)) {
    $aMainNoti[] = $row;
}
$nMainNotiCount = count($aMainNoti);


$sSqlFeatured = "SELECT * FROM t_noticias WHERE FEATURED=1 ORDER BY ID DESC LIMIT 0,4";
$sQueryFeatured = mysql_query($sSqlFeatured);
?>
<header>
    <div class="Banner_slider">
        <div class="banner">
            <ul>
                <li style="background-image: url(img/img1.jpg); background-size: 100%;"></li>
                <li style="background-image: url(img/img2.jpg); background-size: 100%; "></li>
                <li style="background-image: url(img/img3.jpg); background-size: 100%; "></li>
            </ul>
        </div>
    </div>
</header>

<div class="container ">

    <div class="content_info">
        <div class="box">
            <h2>Copa de la Juventud</h2> 
            <div class="box_img1"></div>
            <h4>Diviertete y Conoce!</h4>
            <p>
                Es un torneo intercantonal de la zona sur de Costa Rica destinado en  promover el deporte 
                para mantener una comunidad sana lejos de las malos habitos y vicios.
            </p>
        </div>
        <div class="box">
            <h2>Inscriba su Torneo</h2> 
            <div class="box_img2"></div>
            <h4>Disfrute su evento</h4>
            <p>
                La casa de la Juventud Ofrece su servicios de gestion de campeonatos, profecionales o aficionados.<br/>
                Inscriba su torneo aqui y despreocupese de gentiones administrativas.
            </p>
        </div>
        <div class="box">
            <h2>Inscriba su Equipo</h2> 
            <div class="box_img3"></div>
            <h4>Demostra que son los mejores</h4>
            <p>
                Incriba su equipo ahora, aqui podra encontrar un gran numero de campeonatos que se realizan en la zona sur de Costa Rica.
            </p>
        </div>
    </div>
    <section class="noti_slider">

        <!--- ------------------------------------ SLIDER lofslidernews content ------------------------------------------------ --->
        <div id="jslidernews2" class="lof-slidecontent featured" style="">
            <!-- MAIN CONTENT -->
            <div class="main-slider-content" style="">
                <div class="sliders-wrapper" >
                    <ul class="sliders-wrap-inner" >
                        <?php
                        for ($nI = 0; $nI < $nMainNotiCount; $nI++) {
                            ?>
                            <li>
                                <img src="<?php echo 'admin/noticias/' . $aMainNoti[$nI]['URL_IMAGEN']; ?>" alt="<?php echo $aMainNoti[$nI]['TITULO']; ?>" title="<?php echo $aMainNoti[$nI]['TITULO']; ?>"/>
                                <div class="slider-description">
                                    <a href="<?php echo 'noticia_detalle.php?id=' . $aMainNoti[$nI]['ID']; ?>">
                                        <h4><?php echo $aMainNoti[$nI]['TITULO']; ?></h4>
                                    </a>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- END MAIN CONTENT -->
            <!-- NAVIGATOR -->
            <div class="navigator-content">
                <div class="navigator-wrapper" >
                    <ul class="navigator-wrap-inner">
                        <?php
                        for ($nI = 0; $nI < $nMainNotiCount; $nI++) {
                            ?>


                            <li >
                                <div>
                                    <img src="<?php echo 'admin/noticias/' . $aMainNoti[$nI]['URL_IMAGEN']; ?>" alt="<?php echo $aMainNoti[$nI]['TITULO']; ?>" title="<?php echo $aMainNoti[$nI]['TITULO']; ?>" />
                                    <h4><?php echo $aMainNoti[$nI]['TITULO']; ?></h4>
                                </div>
                            </li>

                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!--- ---------------- END OF NAVIGATOR -------------------- --->
        </div>
        <!--- ------------------------------------ END OF THE CONTENT ------------------------------------------------ --->

    </section>
</div>
<section class="left_panel">
    <div class="container ">
        <div class="sponsor_slider in_line">
            <div class="in_line sponsor">
                <img src="img/sponsor/bn.png" alt="Banco Nacional" />
            </div>
            <div class="in_line sponsor">
                <img src="img/sponsor/coo.png" alt="Banco Nacional" />
            </div>
            <div class="in_line sponsor">
                <img src="img/sponsor/coo2.png" alt="Banco Nacional" />
            </div>
            <div class="in_line sponsor">
                <img src="img/sponsor/mon.png" alt="Banco Nacional" />
            </div>
            <div class="in_line sponsor">
                <img src="img/sponsor/pop.jpg" alt="Banco Nacional" />
            </div>
        </div>
    </div>
</section>

<div class="container ">
    <ul class="blog_column">
        <?php
        $sC1 = '<li>';
        $sC2 = '<li>';
        $nCol = '0';
        while ($aRowFeatured = mysql_fetch_assoc($sQueryFeatured)) {

            $sBoxNoti = '
            <div class="new_box">
                <h3>' . $aRowFeatured['TITULO'] . '</h3>
                <img src="admin/noticias/' . $aRowFeatured['URL_IMAGEN'] . '" alt="' . $aRowFeatured['TITULO'] . '" />
                <p>' . substr($aRowFeatured['DESCRIPCION_CORTA'], 0, 89) . '... <a href="noticia_detalle.php?id=' . $aRowFeatured['ID'] . '">Leer Mas</a> </p>
            </div>';

            if ($nCol == '0') {
                $sC1 = $sC1 . $sBoxNoti;
                $nCol = '1';
            } else {
                $sC2 = $sC2 . $sBoxNoti;
                $nCol = '0';
            }
        }
        $sC1 = $sC1 . '</li>';
        $sC2 = $sC2 . '</li>';
        echo $sC1;
        echo $sC2;
        ?>
        <li>   
            <h4>Ultimos resultados</h4>
            <!--Horizontal Tab-->
            <div id="horizontalTab">
                <ul class="resp-tabs-list">
                    <li>Copa Juventud</li>
                    <li>U-15</li>
                </ul>
                <div class="resp-tabs-container">
                    <div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravida mollis.</p>
                    </div>
                    <div>
                        <p>This tab has icon in consectetur adipiscing eliconse consectetur adipiscing elit. Vestibulum nibh urna, ctetur adipiscing elit. Vestibulum nibh urna, t.consectetur adipiscing elit. Vestibulum nibh urna,  Vestibulum nibh urna,it.</p>
                    </div>
                </div>
            </div>
            <br/>
            <h4>Twitter</h4>
            <div>
                <a class="twitter-timeline" href="https://twitter.com/erick_m91" data-widget-id="412962819106025472">Tweets por @erick_m91</a>
                <script>
                    !function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + "://platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");
                </script>
            </div>
            <div class="clear" ></div>
            <div class="fb-like-box" data-href="http://www.facebook.com/FacebookDevelopers" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
        </li>
    </ul>
    <hr>
    <div class="last_new">

        <h5>Informacion reciente de los torneos</h5>
        <!--vertical Tabs-->
        <div id="verticalTab">
            <ul class="resp-tabs-list">
                <li>Resultados</li>
                <li>Proxima Fecha</li>
                <li>Tabla General</li>
                <li>Tabla de Grupos</li>
            </ul>
            <div class="resp-tabs-container">
                <div>
                    <?php $var_estado_jornada = 4; ?>
                    <span> <?php include("resultados.php"); ?> </span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravida mollis.</p>
                </div>
                <div>
                    <?php $var_estado_jornada = 2; ?>
                    <span><?php include("prox_jor.php"); ?></span>
                    <p>This tab has icon in it.</p>
                </div>
                <div>
                    <span><?php include("tabla_grupos2.php"); ?></span>
                    <p>Suspendisse blandit velit Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravid urna gravid eget erat suscipit in malesuada odio venenatis.</p>
                </div>
                <div>
                    <p>d ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravida mollis.Suspendisse blandit velit eget erat suscipit in malesuada odio venenatis.</p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <br/>
    </div>
</div>
<div class="content"> </div>


<?php
include 'inc.footer.php';
?>
