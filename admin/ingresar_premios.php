<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php'); 
include('sec/inc.menu.php');

$cadena = "SELECT * FROM t_torneo WHERE ACTUAL=1";
$consulta_torneo = mysql_query($cadena, $conn);
$fila = mysql_fetch_assoc($consulta_torneo);
?>

<style type="text/css">
    .contenedor {
        min-height:25px;
        min-width:250px;
        height:auto !important;
        height:25px;
    }
    .contenedor2 {
        min-height:80px;
        min-width:250px;
        height:auto !important;
        height:80px;
    }
    .contenedor3 {
        min-height:240px;
        min-width:250px;
        height:auto !important;
        height:240px;
    }

</style>
<script>
    function obtenerElementos() {
        var arreglo_div = new Array();
        arreglo_div[0] = "premio_llaves";
        arreglo_div[1] = "premio_m_batido";
        arreglo_div[2] = "premio_m_ofensiva";
        arreglo_div[3] = "premio_m_disiplinado";
        arreglo_div[4] = "premio_goleador";
        arreglo_div[5] = "premio_recopa";
        var arreglo_hidden = new Array();
        arreglo_hidden[0] = "hdn_id_pr_llaves";
        arreglo_hidden[1] = "hdn_id_m_batido";
        arreglo_hidden[2] = "hdn_id_m_ofensiva";
        arreglo_hidden[3] = "hdn_id_m_disiplinado";
        arreglo_hidden[4] = "hdn_id_goleador";
        arreglo_hidden[5] = "hdn_id_recopa";

        for (i = 0; i <= 5; i++) {
            var partidos = (document.getElementsByClassName(arreglo_div[i]));
            var hidden = document.getElementById(arreglo_hidden[i]);
            partidos.each(function(lista) {
                var partidoID = lista.id;
                hidden.value = Sortable.sequence(lista);
            });
        }
    }

</script>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2>Premios</h2>
<?php
if ($fila['INSTANCIA'] >= 3) {
    //obtener el evento de llaves
    $sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=2";
    $query_llave = mysql_query($sql_llave, $conn);
    $row_llave = mysql_fetch_assoc($query_llave);



    //obterner evento de grupos
    $sql_grupos = "SELECT * FROM t_eventos WHERE ID_TORNEO=" . $fila['ID'] . " and TIPO=1";
    $query_grupos = mysql_query($sql_grupos, $conn);
    $row_grupos = mysql_fetch_assoc($query_grupos);

    //obtener los finalistar de fase de llaves
    $sql_equi = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] .
            ' ORDER BY PAR_JUG_ACU DESC,PAR_GAN_ACU DESC LIMIT 0,4';
    $query_equi = mysql_query($sql_equi, $conn);

    //obtener los equipos menos batidos
    $sql_equi_m_batido = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] .
            ' ORDER BY GOL_RES_ACU ASC,PAR_GAN_ACU DESC LIMIT 0,4';
    $query_equi_m_batido = mysql_query($sql_equi_m_batido, $conn);

    //obtener los equipos con mejor ofensiva
    $sql_equi_m_ofensiva = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
				LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
				LEFT JOIN t_est_equi ON t_equipo.ID=t_est_equi.ID_EQUI
				WHERE t_even_equip.ID_EVEN=" . $row_llave['ID'] .
            ' ORDER BY GOL_ANO_ACU DESC,PAR_GAN_ACU DESC LIMIT 0,4';
    $query_equi_m_ofensiva = mysql_query($sql_equi_m_ofensiva, $conn);

    //obtener los equipos disiplinados
    $sql_equi_dis = "SELECT *,(t_equipo.ID)AS ID_EQUI FROM t_even_equip
					LEFT JOIN t_equipo ON t_even_equip.ID_EQUI=t_equipo.ID
					WHERE t_even_equip.ID_EVEN=" . $row_grupos['ID'];
    $query_equi_dis = mysql_query($sql_equi_dis, $conn);
    $cant_equi = mysql_num_rows($query_equi_dis);

    $sql_goleador = "
        SELECT 
        *,
        (t_personas.NOMBRE)AS NOM_JUG,
        (t_personas.ID)AS ID_JUG 
        FROM t_est_jug_disc ejd
        LEFT JOIN t_personas ON ejd.ID_PERSONA=t_personas.ID
        WHERE ejd.ID_TORNEO=" . $fila['ID'] . ' 
        ORDER BY ejd.GOLANO DESC LIMIT 0,5';
    $consulta_goleador = mysql_query($sql_goleador, $conn);
    ?>
    <form action="guardar_premios.php" method="post" onsubmit="obtenerElementos();">
        <table>
            <tr bgcolor="#EFF1FC">
                <td><input type="submit" value="Guardar"></td>
                <td><input type="hidden" name="hdn_id_torneo" value="' . $fila['ID'] . '"></td>
                <td></td>
            </tr>
            <tr bgcolor="#DADEFC">
                <td>
                    <table>
                        <tr>
                            <td>
                            </td>
                            <td>Fase Llaves</td>
                        </tr>
                        <tr>
                            <td>
                                1<br>2<br>3<br>4<br>
                            </td>
                            <td>
                                <div style="background:#ccc"  class="contenedor2 premio_llaves" id="idPremio_llaves">	
                                </div>
                                <input type="hidden" name="hdn_pr_llaves" id="hdn_id_pr_llaves" value="">
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="200px"></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="width:250px;background:#CCC;" id="lista_llaves" class="lista contenedor2">
                                    <?php
                                    while ($row_equi = mysql_fetch_assoc($query_equi)) {
                                        echo '<div style="background:#FF0;" id="e_' . $row_equi["ID_EQUI"] . '" >* ' . $row_equi['NOMBRE'] . '</div>';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr bgcolor="#EFF1FC">
                <td>
                    <table>
                        <tr>
                            <td>
                            </td>
                            <td>Arco Menos Batido</td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div style="background:#ccc"  class="contenedor premio_m_batido" id="idPremio_m_batido">	
                                </div>
                                <input type="hidden" name="hdn_m_batido" id="hdn_id_m_batido" value="">
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="200px"></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="width:250px;background:#CCC;" id="lista_m_batido" class="lista contenedor2">
                                    <?php
                                    while ($row_equi_m_batido = mysql_fetch_assoc($query_equi_m_batido)) {
                                        echo '<div style="background:#FF0;" id="e_' . $row_equi_m_batido["ID_EQUI"] . '" >* ' . $row_equi_m_batido['NOMBRE'] . '</div>';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr bgcolor="#DADEFC">
                <td>
                    <table>
                        <tr>
                            <td>
                            </td>
                            <td>Mejor Ofensiva</td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div style="background:#ccc"  class="contenedor premio_m_ofensiva" id="idPremio_m_ofensiva">	
                                </div>
                                <input type="hidden" name="hdn_m_ofensiva" id="hdn_id_m_ofensiva" value="">
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="200px"></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="width:250px;background:#CCC;" id="lista_m_ofensiva" class="lista  contenedor2">
                                    <?php
                                    while ($row_equi_m_ofensiva = mysql_fetch_assoc($query_equi_m_ofensiva)) {
                                        echo '<div style="background:#FF0;" id="e_' . $row_equi_m_ofensiva["ID_EQUI"] . '" >* ' . $row_equi_m_ofensiva['NOMBRE'] . '</div>';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr  bgcolor="#EFF1FC">
                <td>
                    <table>
                        <tr>
                            <td>
                            </td>
                            <td>Mas Disiplinado</td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td><div style="background:#ccc"  class="contenedor premio_m_disiplinado" id="idPremio_m_disiplinado">	
                                </div>
                                <input type="hidden" name="hdn_m_disiplinado" id="hdn_id_m_disiplinado" value="">
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="200px"></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="width:250px;background:#CCC;" id="lista_m_disiplinado1" class="lista contenedor3">
                                    <?php
                                    $contador = 0;
                                    while ($row_equi_dis = mysql_fetch_assoc($query_equi_dis)) {

                                        if ($contador == ($cant_equi / 2)) {
                                            echo '</div>
						</td>
						<td>
							<div style="width:250px;background:#CCC;" id="lista_m_disiplinado2" class="lista contenedor3">';
                                        }
                                        echo '<div style="background:#FF0;" id="e_' . $row_equi_dis["ID_EQUI"] . '" >* ' . $row_equi_dis['NOMBRE'] . '</div>';
                                        $contador++;
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr bgcolor="#DADEFC">
                <td>
                    <table>
                        <tr>
                            <td></td>
                            <td>Goleador</td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div style="background:#ccc"  class="contenedor premio_goleador" id="idPremio_goleador">	
                                </div>
                                <input type="hidden" name="hdn_goleador" id="hdn_id_goleador" value="">
                            </td>
                        </tr>
                    </table>				
                </td>
                <td width="200px"></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div style="width:250px;background:#CCC;" id="lista_goleador" class="lista contenedor">
                                    <?php
                                    while ($row_goleador = mysql_fetch_assoc($consulta_goleador)) {
                                        echo '<div style="background:#FF0;" id="e_' . $row_goleador["ID_JUG"] . '" >* ' . $row_goleador['NOM_JUG'] . ' ' . $row_goleador['APELLIDO1'] . ' ' . $row_goleador['APELLIDO2'] . '</div>';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
<script>
    function crear_drag_llaves() {
        var este = new Array();
        var i;
        este[0] = "idPremio_llaves";
        este[1] = "lista_llaves";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_llaves();

    function crear_drag_m_batido() {
        var este = new Array();
        var i;
        este[0] = "idPremio_m_batido";
        este[1] = "lista_m_batido";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_m_batido();


    function crear_drag_m_ofensiva() {
        var este = new Array();
        var i;
        este[0] = "idPremio_m_ofensiva";
        este[1] = "lista_m_ofensiva";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_m_ofensiva();

    function crear_drag_m_disiplinado() {
        var este = new Array();
        var i;
        este[0] = "idPremio_m_disiplinado";
        este[1] = "lista_m_disiplinado1";
        este[2] = "lista_m_disiplinado2";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_m_disiplinado();

    function crear_drag_recopa() {
        var este = new Array();
        var i;
        este[0] = "idPremio_recopa";
        este[1] = "lista_recopa";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_recopa();

    function crear_drag_goleador() {
        var este = new Array();
        var i;
        este[0] = "idPremio_goleador";
        este[1] = "lista_goleador";
        for (i = 0; i < este.length; i++) {
            Sortable.create(este[i], {
                tag: 'div',
                dropOnEmpty: true,
                containment: este,
                constraint: false});
        }
    }
    crear_drag_goleador();
</script>
<?php
include('sec/inc.footer.php');
?>
