<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include 'module/equipos/equipos.php';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();
$oEquipos = new equipos();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEventoGrupos = $oEventos->getEvenByInstancia($sTorVerID, '1');
$aEventoLLaves = $oEventos->getEvenByInstancia($sTorVerID, '2');

$aEquipos = $oEquipos->getEquiposByEvento($aEventoLLaves['ID']);
$nEquipos = count($aEquipos);

$nTotalJornadasGrupos = $oJornadas->getMaxJornadasByEvento($aEventoGrupos['ID']);
$nTotalJornadasLlaves = $oJornadas->getMaxJornadasByEvento($aEventoLLaves['ID']);


include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2>Llaves - Actualizar fases</h2>
<hr/>
<form action="llaves_actualizar_guardar.php" method="post"  id="frmLlavesActualizar">
    <div >
        <input class="right buton_css" type="submit" value="Guardar">
    </div>
    <div class="clear"></div>
    <table>
        <tr>
            <td class="align_top w_1">
                <h2>Equipos disponibles</h2>
                <input type="button" value="Resetear" class=" buton_css" id="btnResetear"> 
                <div class="clear"></div>
                <br/>
                <div id="lista" class="lista contenedor_equipos">
                    <?php
                    for ($index = 0; $index < $nEquipos; $index++) {
                        echo '<div class="drag_div" id="e_' . $aEquipos[$index]["EQ_ID"] . '" >
                            (' . ($index + 1) . ') ' . $aEquipos[$index]['EQ_NOMBRE'] . '
                            </div>';
                    }
                    ?>
                </div>
            </td>
            <td class="align_top w_full">

                <?php
                $nLlavesFirstJor = $nTotalJornadasGrupos + 1;

//ciclo para recorrer las jornadas	
                for ($i = $nLlavesFirstJor; $i <= $nTotalJornadasLlaves; $i+=2) {

                    $aJornadasFaseCurrent = $oJornadas->getJornadasLlavesByJornadas($aEventoLLaves['ID'], ($i), ($i + 1));
                    $nJornadasFaseCurrent = count($aJornadasFaseCurrent);
                    ?>
                    <div class="fasesBox">
                        <?php
                        $indicador = 0;
                        //ciclo para recorrer los grupos
                        for ($nI = 0; $nI < $nJornadasFaseCurrent; $nI++) {

                            //si es el partido de ida
                            if ($indicador == 0) {
                                echo ' 
                                    <table class="llave_box_table">
                                        <tr > 
                                            <td >Equipos</td>
                                            <td class="llaves_tdw">J.' . ($i) . '</td> 
                                            <td class="llaves_tdw">J.' . ($i + 1) . '</td>
                                            <td class="llaves_tdw">Total</td> 
                                        </tr>';

                                $id_partido_anterior = $aJornadasFaseCurrent[$nI]['ID'];
                                $nombre_equi_casa = $aJornadasFaseCurrent[$nI]['NOM_CASA'];
                                $nMarCasaAnt = $aJornadasFaseCurrent[$nI]['MAR_CASA'];
                                $nombre_equi_vis = $aJornadasFaseCurrent[$nI]['NOM_VISITA'];
                                $nMarVisitaAnt = $aJornadasFaseCurrent[$nI]['MAR_VISITA'];
                                $estado = $aJornadasFaseCurrent[$nI]['ESTADO'];

                                $indicador = 1;
                            }
                            //si es el partido de vuelta
                            else {
                                $indicador = 0;

                                $sFieldEquipos = '';
                                $nTotalEquipoCasa = ($nMarCasaAnt + $aJornadasFaseCurrent[$nI]['MAR_VISITA']);
                                $nTotalEquipoVisita = ($nMarVisitaAnt + $aJornadasFaseCurrent[$nI]['MAR_CASA']);
                                $sRowSpan = '';
                                $sInvisible = '';

                                //si es una jornada por jugar y no se an actualizado los equipos
                                if (($aJornadasFaseCurrent[$nI]['ID_EQUI_CAS'] == '0') && ($aJornadasFaseCurrent[$nI]['ID_EQUI_VIS'] == '0') && (($aJornadasFaseCurrent[$nI]['ESTADO'] == 2)) || ($estado == 2)) {
                                    $arreglo_div[] = $aJornadasFaseCurrent[$nI]['GRUPO'];

                                    $sFieldEquipos = '
                                        <div class=" grupo_' . $aJornadasFaseCurrent[$nI]['GRUPO'] . ' contenedor_equipos w_cont" id="idPartido_' . $aJornadasFaseCurrent[$nI]['GRUPO'] . '">
                                        </div>
                                        ';

                                    echo '
                                        <input type="hidden" name="h_idGrupos[]" value="' . $id_partido_anterior . '/' . $aJornadasFaseCurrent[$nI]['ID'] . '">
                                        <input type="hidden" value="" name="h_grupo[]" id="h_idgrupo_' . $aJornadasFaseCurrent[$nI]['GRUPO'] . '">  
                                        ';
                                    $sRowSpan = ' rowspan="2"';
                                    $sInvisible = 'invisible';
                                }
                                //mostrar los partidos sin permitir modificar
                                else {
                                    $sFieldEquipos = $nombre_equi_casa;
                                }
                                echo '
                                    <tr>
                                        <td  bgcolor="#DADEFC" ' . $sRowSpan . '>' . $sFieldEquipos . '</td>
                                        <td  bgcolor="#EFF1FC">' . $nMarCasaAnt . '</td>
                                        <td  bgcolor="#DADEFC">' . $aJornadasFaseCurrent[$nI]['MAR_VISITA'] . '</td>
                                        <td  class="total_box">' . $nTotalEquipoCasa . '</td>
                                    </tr>
                                    <tr>
                                        <td  bgcolor="#DADEFC" class="' . $sInvisible . '">' . $nombre_equi_vis . '</td> 
                                        <td  bgcolor="#EFF1FC">' . $nMarVisitaAnt . '</td>
                                        <td  bgcolor="#DADEFC">' . $aJornadasFaseCurrent[$nI]['MAR_CASA'] . '</td>
                                        <td  class="total_box">' . $nTotalEquipoVisita . '</td>
                                   </tr> 
                                </table>
                                    ';
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    var arra_items = new Array();
    var arra_nom = new Array();
<?php
for ($index = 0; $index < $nEquipos; $index++) {
    echo '
        arra_items[' . $index . ']=' . $aEquipos[$index]["EQ_ID"] . ';
        arra_nom[' . $index . ']=" ' . $aEquipos[$index]['EQ_NOMBRE'] . '";';
}
?>
    $(function() {
        function enumerar() {
            $('.contenedor_equipos  > .drag_div').each(function() {
                $(this).prepend("(" +
                        ($(this).index() + 1) + ") ");
            });
        }


        function crear_drag() {
            $(".contenedor_equipos").sortable({
                connectWith: ".contenedor_equipos",
                placeholder: "Arrastre aqui"
            }).disableSelection();
        }
        crear_drag();

        $("#btnResetear").click(function() {
            rellenar();
        });

        function rellenar() {
            var i;
            var lista = $("#lista");
            for (i = 0; i < arra_items.length; i++) {
                var strDiv = '<div class="drag_div" id="' + "e_" + arra_items[i] + '">' + arra_nom[i] + '</div>';
                var contenedores = $('#e_' + arra_items[i]);
                contenedores.remove();
                lista.append(strDiv);
            }
            enumerar();
            crear_drag();
        }
 
        function obtenerElementos() {
            var arreglo_div = new Array();
            var arreglo_hidden = new Array();

<?php
for ($i = 0; $i < count($arreglo_div); $i++) {
    echo '
            arreglo_div[' . ($i) . ']="grupo_' . $arreglo_div[$i] . '";
            arreglo_hidden[' . ($i) . ']="h_idgrupo_' . $arreglo_div[$i] . '";';
}
?>
            
            var cantidad_grupos =<?php echo count($arreglo_div); ?>;
            for (i = 0; i < cantidad_grupos; i++) { 
                var sorted =  $('.' + arreglo_div[i]).sortable("toArray");
                $('#'+arreglo_hidden[i]).val(sorted); 
            }
            return false;
        }

        $("#frmLlavesActualizar").submit(function() {
            obtenerElementos();
        });
        
    }); 
</script>
<?php
include('sec/inc.footer.php');
?>