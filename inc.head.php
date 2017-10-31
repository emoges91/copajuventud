<?php
include('admin/conexiones/conec.php');

$sql_tor = "SELECT * FROM t_torneo WHERE MOSTRAR=1";
$query_tor = mysql_query($sql_tor, $conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="img/logo.jpg" rel="shortcut icon">
        <title>Copa Juventud | Casa de la Juventud</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="initial-scale=1.0">
        <meta name="description" content="Espacio web para desplegar estadisticas, resultados, calendarios, etc.." />
        <meta name="robots" content="INDEX,FOLLOW" />
        <meta name="keywords" content="Perez Zeleon, futbol, campeonatos, copa rotativa, copa juventud, casa de la juventud">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/tabs.css" />
        <link rel="stylesheet" type="text/css" href="css/menus.css" />

        <script src="js/jquery.js"></script>
        <script src="js/unslider.js"></script>
        <script type="text/javascript" src="./js/easyResponsiveTabs.js"></script>
        <script type="text/javascript" src="./js/lofslidernews-2.0.js"></script>
        <script type="text/javascript" src="./js/main.js"></script>
        <script type="text/javascript" src="./js/jquery.easing.1.3.js"></script>
        <script>
            $(function() {
                $('.banner').unslider({
                    fluid: true,
                    dots: true,
                    speed: 600
                });
            });
        </script>
        <meta http-equiv="Content-Language" content="es">
        <meta name="author" content="Erick Monge">
        <meta name="copyright" content="2013">
        <meta name="rating" content="General">
        <meta http-equiv="Reply-to" content="monge.erick@gmail.com">
        <meta name="creation_Date" content="12/13/2013">
        <meta name="revisit-after" content="NO">
        <meta name="doc-rights" content="Public">

    </head>
    <body>
        <div class="top_menu">
            <div class="menuwrapper">
                <a href="./index.php">
                    <div class="logos_div">
                        <div class="logo left logo_copa "></div>
                        <div class="logo left logo_casa"></div>
                        <div class="clear"></div>
                    </div>
                </a>

                <ul id="menu_top">
                    <li><a href="./noticia.php">Noticias</a></li>
                    <li><a href="./imagenes.php">Fotos</a></li>
                    <li><a href="./videos.php">Videos</a></li>
                    <li class='has-sub'><a href="./docs.php">Documentos</a>
                        <ul>
                            <li><a href="./reglamento.php">Reglamento</a></li>
                            <li><a href="./reglamento.php?tipo=2">Actas de comite disiplinario</a></li>
                            <li><a href="./reglamento.php?tipo=3">Actas de comite competicion</a></li>
                            <li><a href="./reglamento.php?tipo=5">Costos arbitraje</a></li>
                            <li><a href="./reglamento.php?tipo=6">Informe arbitral</a></li>
                            <li><a href="./reglamento.php?tipo=7">Revision arbitral</a></li>
                            <li><a href="./reglamento.php?tipo=4">Otros documentos</a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href="./comites.php">Comites</a>
                        <ul>
                            <li><a href="./comite.php">Disiplinario</a></li>
                            <li><a href="./comite.php?tipo=2">Competicion</a></li>
                            <li><a href="./comite.php?tipo=3">Apelacion</a></li>
                        </ul>
                    </li>
                    <li><a href="./contactos.php">Contactos</a></li>
                    <li class='has-sub item_torneos'>
                        <a href="./torneos.php" class="">Torneos</a>
                        <ul>
                            <?php
                            while ($row_tor = mysql_fetch_assoc($query_tor)) {
                                ?>
                                <li><a href="./resultados.php?tor=<?php echo $row_tor['ID']; ?>" ><?php echo $row_tor['NOMBRE'] . ' ' . $row_tor['YEAR']; ?></a></li>
                                <?php
                            }
                            ?>

                        </ul>
                    </li>
                </ul>
                <div class="in_line right">
                    <div class="icon_face2 in_line"> </div>
                    <div class="icon_twitter2 in_line"> </div>
                </div>
            </div>
        </div>