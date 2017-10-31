<?php
include 'inc.head.php';

$sql = "SELECT * FROM t_img WHERE ID=" . $_GET['ID'];
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);
?>

 
                    <table border="0" width="100%">
                        <tr valign="top">
                            <td rowspan="7">
                                <?php echo'<a href="index.php?pag=detalle_album.php&ID=' . $_GET['IDA'] . '&pg=' . $_GET['pg'] . '&pgpa=' . $_GET['pgpa'] . '" class="hiper"><font size="+2"><p>Volver al album</p></font></a>
				<table align="left" border="0" width="750px" class="tabla_prin">
				<tr id="titulo" align="center">
				<td>
					<font face="Comic Sans MS, cursive" size="+1" color="#0066CC">' . $row['NOMBRE'] . '</font>
				</td>
				</tr>
            	<tr class="normal">
            	<td align="center" colspan="2">
            		<img src="admin/' . $row['URL'] . '" class="mibloque"><br>
            	</td>
				</tr>
				<tr class="normal">
				<td>
					<font size="+1">' . $row['DESCRIP'] . '</font>
				</td>
				</tr>
				<tr class="normal">
				<td colspan="2">
					<div id="fb-root" align="center"></div><script src="http://connect.facebook.net/en_US/all.js#appId=APP_ID&amp;xfbml=1"></script><fb:comments numposts="10" width="700" publish_feed="true"></fb:comments>
				</td>
				</tr>
				<tr>
				</tr>
            	</table>';
                                ?>
                                <script src="http://connect.facebook.net/en_US/all.js#appId=264887889270&amp;xfbml=1"></script>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table class="tabla_prin" width="100%">
                                    <tr id="titulo" style="color:#eee;" align="center">
                                        <td>
                                            <font face="Comic Sans MS, cursive" size="+1" color="#0066CC">Otras Imagenes</font>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $sql2 = "SELECT * FROM t_img WHERE ALBUN='" . $_GET['IDA'] . "' AND ID!=" . $_GET['ID'];
                        $que = mysql_query($sql2, $conn);
                        $row2 = mysql_num_rows($que);
                        if ($row2 <= 4) {
                            $limite = 0;
                            $cant = $row2;
                        } else {
                            $limite = $row2 - 5;
                            $cant = 4;
                        }
                        $sql = "SELECT * FROM t_img WHERE ALBUN='" . $_GET['IDA'] . "' AND ID!='" . $_GET['ID'] . "'ORDER BY ID DESC LIMIT $limite,$cant";
                        $query = mysql_query($sql, $conn);
                        while ($row = mysql_fetch_assoc($query)) {
                            echo'<tr valign="top"><td><table align="right" width="250px" class="tabla_prin">
            	<tr class="odd" id="cuerpo">
            	<td>
           			<a href="index.php?pag=comentar_img.php&ID=' . $row['ID'] . '&IDA=' . $_GET['IDA'] . '&pgpa=' . $_GET['pgpa'] . '&pg=' . $_GET['pg'] . '" class="hiper">' . $row['NOMBRE'] . '</a>
            	</td>
				</tr>
				<tr class="normal" id="cuerpo">
				<td align="center">
					<a href="index.php?pag=comentar_img.php&ID=' . $row['ID'] . '&IDA=' . $_GET['IDA'] . '&pgpa=' . $_GET['pgpa'] . '&pg=' . $_GET['pg'] . '" class="hiper"><img src="admin/' . $row['URL'] . '" width="150px"></a>
				</td>
				</tr>
				</table></td></tr>';
                        }
                        ?>
                </div>
    </table>


<?php
include 'inc.footer.php';
?>