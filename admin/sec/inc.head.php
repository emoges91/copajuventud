<?php
include("conexiones/conec_cookies.php");


if (isset($_GET['tor_ver_id'])) {
    $sTorVerID = $_GET['tor_ver_id'];
} elseif (isset($_SESSION['ID_TORNEO'])) {
    $sTorVerID = $_SESSION['ID_TORNEO'];
} else {
    $sTorVerID = '';
}

$sNombreTor = '';

$sSqlTor = "SELECT * FROM t_torneo WHERE ID='" . $sTorVerID . "'";
$oQueryTor = mysql_query($sSqlTor, $conn);
$nCantTor = mysql_num_rows($oQueryTor);
$aTorData = mysql_fetch_array($oQueryTor);

if ($nCantTor > 0) {
    $sNombreTor = $aTorData['NOMBRE'] . ' ' . $aTorData['YEAR'] . ' - ' . $sTorVerID;
    $_SESSION['ID_TORNEO'] = $sTorVerID;
}
?>
<html>
    <head>
        <title>Adiministracion</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
        <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/menu.css">
        <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <link rel="stylesheet" href="script_piker/piker.css" type="text/css" media="screen" charset="utf-8" /> 
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
        <link rel="stylesheet" href="script_piker/piker.css" type="text/css" media="screen" charset="utf-8" /> 
        <link rel="stylesheet" type="text/css" href="css/anytime.css" />
        <link rel="stylesheet" type="text/css" href="css/search.css" />

        <script type="text/javascript" src="js/jquery.js"  charset="utf-8"></script>
        <script type="text/javascript" src="scripts/jquery.prettyPhoto.js" charset="utf-8"></script>
        <script type="text/javascript" src="time/anytime.js"></script>
        <script type="text/javascript" src="script_piker/picker.js"  charset="utf-8"></script>	
        <!--<script type="text/javascript" src="js/anytime.js"></script>-->

        <style>
            .mibloque{
                width:expression(document.body.clientWidth > 175? "175px": "auto" );
                max-width:175px;
            }
        </style>

        <style type="text/css">
            .contenedor {
                min-height:45px;
                min-width:150px;
                height:auto !important;
                height:45px;
            }

        </style>
        <style type="text/css">
            .time { background-image:url("time/clock.png");
                    background-position:right center; background-repeat:no-repeat;
                    border:1px solid #FFC030;color:#3090C0;font-weight:bold
            }
        </style>


    </head>
    <body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <div class="wrap">
            <header >
                <br/>
                <div class="tor_nomb">
                    Torneo: 
                    <b>
                        <a href="torneo_tabla_general.php?tor_ver_id=<?php echo $sTorVerID; ?>">
                            <?php echo $sNombreTor; ?>
                        </a>
                    </b>
                </div>
                <a class="right" href="cerrar.php" title="Cerrar sesion">Cerrar sesion</a>
            </header>
            <div class="clear"></div>
            <hr/>

            <div id='cssmenu'>
                <ul>
                    <li class='active'><a href='index.php'><span>Home</span></a></li> 
                    <li class='has-sub'><a href="#" ><span>Equipos</span></a>
                        <ul>
                            <li class='has-sub'><a href="equipos.php" title="Equipos"><span>Equipos</span></a></li>
                            <li class='has-sub'><a href="registrar_canchas.php" title="Registrar Canchas"><span>Canchas</span></a></li>
                            <li class='has-sub'><a href="personas.php" title="Personas"><span>Personas </span></a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href="#" title="Torneos"><span>Torneos</span></a>
                        <ul>
                            <li class='has-sub'><a href="torneo.php" title="Editor Torneos"><span>Editor Torneos</span></a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href="documentos.php" title="Documentos"><span>Documentos</span></a></li>
                    <li class='has-sub'><a  href="comites.php" title="Directivas"><span>Directivas</span></a></li>
                    <li class='has-sub'><a href="noticias.php" title="Noticias"><span>Noticias</span></a></li>
                    <li class='has-sub'><a href='#'><span>Multimedia</span></a>
                        <ul>
                            <li class='has-sub'><a href="videos.php" title="agregar videos"><span>Videos</span></a></li>
                            <li class='has-sub'><a href="album.php" title="agregar imagenes"><span>Fotos</span></a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href="patrocinador.php" title="Patrocinadores"><span>Patrocinadores</span></a></li>
                    <li class='has-sub'><a href="TorneosAmigos/index.php" title="Torneos Amigos"><span>Torneos Amigos</span></a></li>
                </ul>
            </div>
            <div class="clear"></div>

            <div class="content">