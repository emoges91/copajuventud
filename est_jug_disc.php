<?php
include 'inc.head.php';

$sTorneoID = (isset($_GET['tor']) ? $_GET['tor'] : '0');

 $cadena = "SELECT * FROM t_torneo WHERE ID=" . $sTorneoID . "";
                $consulta_torneo = mysql_query($cadena, $conn);
                $fila = mysql_fetch_assoc($consulta_torneo);
                $cant_tor = mysql_num_rows($consulta_torneo);

include 'inc.menu_tor.php';
?>

<style type="text/css">
    #Container {
        position: relative;
        top: 5px; left: 5px;
        width: 1015px; height: 600px;
        overflow: hidden;
    }
    .Scroller-Container { position: relative; background: transparent; }
    h3 {
        margin: 0 0 5px 0;
        font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
        font-size: 14px;
        color: #0B6589;
    }
    p {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #054C68;
        text-align: justify;
        text-indent: 10px;
    }
    #Scrollbar-Container {
        position: relative;
        top: 0px; left: 0px;
        width: 10px; height: 600px;
    }
    .Scrollbar-Track {
        width: 10px; height: 600px;
    }
    .Scrollbar-Handle {
        position: absolute;
        width: 10px; height: 50px;
        background-color: #212121;
    }
    #sbLine {
        position: relative;
        width: 6px;
        height: 5px;
        left: 7px;
        background-color: #CACACA;
        font-size: 0px;
    }
    #List {
        height:600px
            position: relative;
    }
    #List a {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #7ABAD3;
        display: inline-block;
        text-decoration: none;
        padding: 3px;
    }
    #List a:hover {
        color: #0B6589;
    }
</style>
<script type="text/javascript" src="scripts/jsScroller.js"></script>
<script type="text/javascript" src="scripts/jsScrollbar.js"></script>
<script type="text/javascript" src="scripts/jsScrollerTween.js"></script>
<script type="text/javascript">
    window.onload = function() {
        scroller = new jsScroller(document.getElementById("Container"), 850, 600);
        scrollbar = new jsScrollbar(document.getElementById("Scrollbar-Container"), scroller, true);
        scrollTween = new jsScrollerTween(scrollbar, true);
        scrollTween.stepDelay = 30;

        scrollbar._moveContentOld = scrollbar._moveContent;
        scrollbar._moveContent = function() {
            this._moveContentOld();
            var percent = this._y / (this._trackHeight - this._handleHeight);
            document.getElementById("sbLine").style.top = Math.round((this._handleHeight - 5) * percent) + "px";
        };

        findTags("h3", document.getElementById("Container"));
    }

    function findTags(tag, parent) {
        var tags = parent.getElementsByTagName(tag);
        var cont = document.getElementById("Links");
        for (var i = 0; i < tags.length; i++) {
            cont.innerHTML += "<a href=\"javascript:scrollbar.tweenTo(" + tags[i].offsetTop + ")\">" + tags[i].innerHTML + "</a>";
        }
    }
</script>
</head>
<body>
    
                <?php
     
               

                $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . "";
                $query = mysql_query($sql, $conn);
                while ($row = mysql_fetch_assoc($query)) {
                    $cadena_equi = "SELECT * FROM t_jornadas WHERE ESTADO=4 AND ID_EVE=" . $row['ID'] . " ORDER BY NUM_JOR ASC";
                    $consulta_total_jornadas = mysql_query($cadena_equi, $conn);
                    while ($total_jornadas = mysql_fetch_assoc($consulta_total_jornadas)) {
                        if (($total_jornadas['MARCADOR_VISITA'] != NULL) AND ($jornadas <= $total_jornadas['NUM_JOR'])) {
                            $jornadas = $total_jornadas['NUM_JOR'];
                        }
                    }
                }
                if ($cant_tor > 0) {
                    echo '<font color="#0B6589" size="+2"><center><b>Tarjetas ' . $fila['NOMBRE'] . ' ' . $fila['YEAR'] . ' Jornada ' . $jornadas . '</b></center></font>
    	<table border="0" width="100%">
    	<tr>
    	<td width="835px">
		<div id="Container">
			<div class="Scroller-Container">';
                    $sql = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " AND TIPO=1";
                    $query = mysql_query($sql, $conn);
                    $row = mysql_fetch_assoc($query);
                    $sql = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
					LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
					WHERE t_even_equip.ID_EVEN=" . $row['ID'];
                    $query = mysql_query($sql, $conn);
                    while ($row = mysql_fetch_assoc($query)) {
                        $sqldisc = "SELECT * FROM t_est_jug_disc WHERE ID_EQUIPO = " . $row['ID_EQUI'] . " AND ID_TORNEO= " . $fila['ID'] . " AND (TAR_AMA=1 OR TAR_ROJ=1)";
                        $querydisc = mysql_query($sqldisc, $conn);
                        $canttar = mysql_num_rows($querydisc);
                        $total_tar = 0;
                        if ($canttar > 0) {
                            echo'<h3>' . $row['NOMBRE'] . '</h3>';
                            $sqljug = "SELECT * FROM t_personas WHERE ID_EQUI=" . $row['ID'] . "";
                            $queryjug = mysql_query($sqljug, $conn);
                            echo '<p><table style="border:1px solid #000"; width="100%" cellpadding="0" cellspacing="0">
						<tr align="center" ><td rowspan="2" style="border:1px solid #000";><font size="-1" color="#054C69">Nombre</font></td><td colspan=' . $jornadas . ' style="border:1px solid #000";><font size="-1" color="#054C69">Jornadas</font></td><td rowspan="2" width="45px" align="center" style="border:1px solid #000";><font size="-1" color="#054C69">Total</font></td></tr>
						<tr>';
                            $i = 1;
                            while ($jornadas >= $i) {
                                echo '<td width="35px" style="border:1px solid #000";><font size="-2" color="#054C69"><center>' . $i . '</center></font></td>';
                                $i++;
                            }
                            echo'</tr>';
                            while ($rowjug = mysql_fetch_assoc($queryjug)) {
                                $tar_ama = 0;
                                $tar_roj = 0;
                                $sqldisc = "SELECT * FROM t_est_jug_disc WHERE ID_EQUIPO = " . $row['ID_EQUI'] . " AND ID_TORNEO= " . $fila['ID'] . " AND ID_JUGADOR=" . $rowjug['ID'] . " AND (TAR_AMA=1 OR TAR_ROJ=1) ORDER BY JORNADA ASC";
                                $querydisc = mysql_query($sqldisc, $conn);
                                $canttar = mysql_num_rows($querydisc);
                                if ($canttar > 0) {
                                    echo '<tr style="border:1px solid #000; background: url(img_tabla/bg_td1.jpg) repeat-x top;"><td style="border:1px solid #000;"><font size="-2" color="#054C69"><center>' . $rowjug['NOMBRE'] . ' ' . $rowjug['APELLIDO1'] . ' ' . $rowjug['APELLIDO2'] . '</center></font></td>';
                                    $x = 0;
                                    while ($rowdisc = mysql_fetch_assoc($querydisc)) {
                                        $x++;
                                        while (($rowdisc['JORNADA'] != $x) and ($rowdisc['JORNADA'] > $x)) {
                                            echo'<td style="border:1px solid #000";> </td>';
                                            $x++;
                                        }
                                        echo'<td style="border:1px solid #000";>';
                                        if (($rowdisc['TAR_AMA'] == 1) and ($rowdisc['TAR_ROJ'] == 0)) {
                                            echo '<table border="0" align="center"><tr><td bgcolor="#F8F400"><font color="#F8F400">A</font></td></tr></table>';
                                            $tar_ama++;
                                        } else {
                                            if (($rowdisc['TAR_AMA'] == 0) and ($rowdisc['TAR_ROJ'] == 1)) {
                                                echo '<table border="0" align="center"><tr><td bgcolor="#FF0000"><font color="#FF0000">R</font></td></tr></table>';
                                                $tar_roj++;
                                            } else {
                                                if (($rowdisc['TAR_AMA'] == 1) and ($rowdisc['TAR_ROJ'] == 1)) {
                                                    echo '<table border="0" align="center"><tr><td bgcolor="#F8F400"><font color="#F8F400">A</font></td></tr><tr><td bgcolor="#FF0000"><font color="#FF0000" size="-1">R</font></td></tr></table>';
                                                    $tar_ama++;
                                                    $tar_roj++;
                                                }
                                            }
                                        }
                                        $tem = $rowdisc['JORNADA'];
                                        echo'</td>';
                                    }
                                    if (($tem < $jornadas) and ($x < $jornadas)) {
                                        while (($tem < $jornadas) and ($x < $jornadas)) {
                                            echo '<td style="border:1px solid #000";> </td>';
                                            $x++;
                                            $tem++;
                                        }
                                    }
                                    echo'<td align="center" style="border:1px solid #000";>';
                                    if (($tar_ama != 0) and ($tar_roj != 0)) {
                                        echo'<table border="0" width="35px" align="center"><tr><td bgcolor="#F8F400"><center>' . $tar_ama . '</center></td></tr><tr><td bgcolor="#FF0000"><center>' . $tar_roj . '</center></td></tr></table>';
                                    } else {
                                        if (($tar_ama != 0) and ($tar_roj == 0)) {
                                            echo'<table border="0" width="35px" align="center"><tr><td bgcolor="#F8F400"><center>' . $tar_ama . '</center></td></tr></table>';
                                        } else {
                                            if (($tar_ama == 0) and ($tar_roj != 0)) {
                                                echo'<table border="0" width="35px" align="center"><tr><td bgcolor="#FF0000"><center>' . $tar_roj . '</center></td></tr></table>';
                                            }
                                        }
                                    }
                                    echo'</td></tr>';
                                }
                            }
                            echo'</table></p>';
                        }
                    }
                    echo'
			</div>
		</div>
		</td>
		<td>
		<div id="Scrollbar-Container">
  			<div class="Scrollbar-Track">
    			<div class="Scrollbar-Handle"><div class="Scrollbar-Handle" id="sbLine">
				</div>
			</div>
  		</div>
		</div>
		</td></tr><tr><td valign="baseline">
		<div id="List" align="center">
  			<h3>Equipos</h3>
  		<div id="Links" align="center">
  		</div>	
	</div></td></tr></table>';
                } else {
                    echo '<p>No hay torneo registrados</p>';
                }
                ?>
         
    <?php
include 'inc.footer.php';
?>