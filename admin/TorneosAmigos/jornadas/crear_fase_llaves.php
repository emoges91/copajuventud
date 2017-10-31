<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            .contenedor {
                min-height:45px;
                min-width:150px;
                height:auto !important;
                height:45px;
            }

        </style>	
        <!--<script src="js/crearLlaves.js" type="text/javascript"></script>-->
        <script src="js/crearLlaves2_0.js" type="text/javascript"></script>
        <script src="lib/prototype.js" type="text/javascript"></script>
        <script src="src/scriptaculous.js" type="text/javascript"></script>
    </head>
    <body onLoad="crear_drag();">
        <?php
        include('../conexiones/conec_cookies.php');

        $cadena = "SELECT * FROM t_torneo WHERE ID=" . $_GET['ID'];
        $consulta_torneo = mysql_query($cadena, $conn);
        $fila = mysql_fetch_assoc($consulta_torneo);

        if ($fila['INSTANCIA'] == 2) {
            //consulta eventos fase de grupos
            $sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $_GET['ID'] . " and TIPO=1";
            $query_grupo = mysql_query($sql_grupo, $conn);
            $cant_grupo = mysql_num_rows($query_grupo);
            $row_grupo = mysql_fetch_assoc($query_grupo);

            //consulta eventos fase de llave
            $sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $_GET['ID'] . " and TIPO=2";
            $query_llave = mysql_query($sql_llave, $conn);
            $cant_llave = mysql_num_rows($query_llave);
            $row_llave = mysql_fetch_assoc($query_llave);

            if (($cant_llave > 0) || ($cant_grupo > 0)) {
                ?>	
                <form name="formulario" action="guardar/guardar_llaves.php" enctype="multipart/form-data" method="post" onSubmit="return validarguardar();">
                    <input name="HidTorneo" type="hidden" value="<?php echo $_GET['ID']; ?>" />
                    <input name="HidNomb" type="hidden" value="<?php echo $_GET['NOMB']; ?>" />
                    <table width="100%">
                        <tr bgcolor="#CCCCCC">
                            <td align="center" colspan="2" >Crear Fase De Llaves</td>
                            <td align="right" >
                                <input type="submit" value="Guardar"><input type="hidden" name="cant_fases" values=""/>
                                    <input type="button" value="Cancelar" onClick="document.location.href = '../mostrar_Torneo.php?ID=<?php echo $_GET['ID']; ?>&NOMB=<?php echo $_GET['NOMB']; ?>';"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="130px">Nombre del torneo:</td>
                            <td><?php echo $fila['NOMBRE']; ?></td>
                        </tr>
                        <tr>
                            <td>Cantidad Partidos Primera Fase: </td>
                            <td>
                                <input type="text" maxlength="2" size="1" name="txt_cant_fase" id="txt_cant_fase">
                                    <input type="button" onClick="principal();" value="Crear Fases">
                                        </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td id="tdfasesCant"></td>
                                        </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $sql = "SELECT * FROM t_even_equip
                    LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
                    WHERE t_even_equip.ID_EVEN=" . $row_grupo['ID'];
                                                    $query = mysql_query($sql, $conn);
                                                    ?>			 
                                                    <div style="width:200px;background:#CCC;" id="lista" class="lista">
                                                        <br id="apartir">                    
                                                            <?php
                                                            while ($row = mysql_fetch_assoc($query)) {
                                                                echo '
                            <div id="e_' . $row["ID"] . '" style="background:#FF9;position:relative;border-bottom:1px solid #ddd;" >* ' . $row['NOMBRE'] . '</div>';
                                                            }
                                                            ?>		
                                                    </div>
                                                    <td>
                                                        <td style="width:40px;">
                                                        </td>
                                                        <td >
                                                            <table id="partidos">
                                                                <tr id="idtr">

                                                                </tr>
                                                            </table>
                                                        </td>
                                                        </tr>
                                                        </table>
                                                        </form>
                                                        <?PHP
                                                    } else {
                                                        echo '<center>No se ha creado un torneo</center>';
                                                    }
                                                } else {
                                                    echo "<script type=\"text/javascript\">
				alert('Se deben de terminar la fase de grupos para avanzar o ya se realizaron la fase de llaves');
				history.go(-1);
			</script>";
                                                }
                                                ?>
                                                <script type="text/javascript">
        var arra_items = new Array();
        var arra_nom = new Array();
<?php
$i = 0;
$query = mysql_query($sql, $conn);
while ($row = mysql_fetch_assoc($query)) {
    echo 'arra_items[' . $i . ']=' . $row['ID'] . ';
                                                arra_nom[' . $i . ']="* ' . $row['NOMBRE'] . '";';
    $i++;
}
?>

        function rellenar() {
            var i;
            var lista = (document.getElementById('lista'));
            for (i = 0; i < arra_items.length; i++) {
                var cadena = 'e_' + arra_items[i];
                var contenedores = document.getElementById(cadena);
                contenedores.parentNode.removeChild(contenedores);

                var texto = document.createTextNode(arra_nom[i]);
                var elemento = document.createElement("div");
                elemento.id = "e_" + arra_items[i];
                elemento.style.background = "#FF9";
                elemento.style.position = "relative";
                elemento.style.borderBottom = "1px solid #ddd";
                elemento.appendChild(texto);
                lista.appendChild(elemento);
            }
        }

        function crear_drag() {
            var este = new Array();
            if (cant_fases > 0) {
                este[0] = "lista";
                if (array_txt_fases.length > 0) {
                    for (i = 1; i <= (array_txt_fases.length + 1); i++) {
                        este[i] = "idpartido_" + i + "_" + 1;
                    }
                }
                else {
                    este[1] = "lista";
                }

                for (var i = 0; i <= (array_txt_fases.length + 1); i++) {
                    Sortable.create(este[i], {
                        tag: 'div',
                        dropOnEmpty: true,
                        containment: este,
                        constraint: false});
                }
            }
        }
                                                </script>
                                                </body>
                                                </html>