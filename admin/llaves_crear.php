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
$aEquipos = $oEquipos->getEquiposByTorneo($sTorVerID);


include('sec/inc.head.php'); 
include('sec/inc.menu.php');



if ($fila['INSTANCIA'] == 2) {
    ?>
    <h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
    <h2>Fase de Llaves - Crear</h2>
    <hr>
    <?php
    if ((count($aEventoLLaves) > 0) || (count($aEventoGrupos) > 0)) {
        ?>
        <form name="formulario" action="llaves_guardar.php" enctype="multipart/form-data" method="post" id="frmLlaves">
            <input type="hidden" name="hCantFases" values="" id="hCantFases"/>
            <div >
                <input class="right buton_css" type="submit" value="Guardar">
            </div>
            <div class="clear"></div>
            <table>
                <tr>
                    <td class="align_top w_1">
                        <h2>Equipos disponibles</h2>
                        <div id="lista" class="lista contenedor_equipos">
                            <?php
                            $nEquipos = count($aEquipos);
                            for ($index = 0; $index < $nEquipos; $index++) {
                                echo ' <div class="drag_div" id="e_' . $aEquipos[$index]["EQ_ID"] . '" >   (' . ($index + 1) . ') ' . $aEquipos[$index]['EQ_NOMBRE'] . '  </div>';
                            }
                            ?>
                        </div>
                    <td>
                    <td class="align_top w_full">
                        <div class="box_settings">
                            <input type="text" maxlength="1" size="1" name="txt_cant_fase" id="txt_cant_fase" >
                            <input type="button" value="Crear Fases" id="btnCrerFases" class="buton_css">
                            Partidos Ida y Vuelta <input type="checkbox" checked="checked" value="1" name="ParIdaVuelta"/>
                            Final Ida y Vuelta <input type="checkbox" checked="checked" value="1" name="FinalIdaVuelta"/>
                            <div id="divFases">

                            </div>
                        </div>
                        <div class="clear"></div>
                        <div id="partidos">
                        </div>
                    </td>
                </tr>
            </table>
        </form>

        <?php
    } else {
        echo '<p>No se ha creado un torneo</p>';
    }
} else {

    if ($fila['INSTANCIA'] == 1) {
        echo "
            <script type=\"text/javascript\">
                    alert('Se deben de terminar la fase de grupos para avanzar a llaves');
                    history.go(-1);
            </script>";
    } else {
        echo "
            <script type=\"text/javascript\">
                    alert('Ya se realizo el sorteo de fase de llaves');
                    history.go(-1);
            </script>";
    }
}
?>
<script type="text/javascript">
    var cantidad_partidos = 0;
    var nFases = 0;
    var FaseActual = 0;

    var arra_items = new Array();
    var arra_nom = new Array();
<?php
$nEquipos = count($aEquipos);
for ($index = 0; $index < $nEquipos; $index++) {
    echo '
        arra_items[' . $index . ']=' . $aEquipos[$index]["EQ_ID"] . ';
        arra_nom[' . $index . ']=" ' . $aEquipos[$index]['EQ_NOMBRE'] . '";
         ';
}
?>
    $(function() {

        function esEntero(numero) {
            if (numero - Math.floor(numero) == 0) {
                return true;
            }
            else {
                return false;
            }
        }

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
        }

        function crear_drag() {
            $(".contenedor_equipos").sortable({
                connectWith: ".contenedor_equipos",
                placeholder: "Arrastre aqui"
            }).disableSelection();
        }
        crear_drag();


        function crearLlaves() {
            var nPartido;
            var nTotalPartidos;

            if (esEntero(nFases) == true) {
                rellenar();
                borrarLlaves();
                for (var FaseActual = 1; FaseActual <= nFases; FaseActual++) {

                    var divFase = document.createElement('div');
                    $(divFase).attr('id', "divFase" + FaseActual);
                    $(divFase).addClass('fasesBox');

                    var divFaseTitulo = '<h3 class="titulo">Fase ' + FaseActual + '</h3>';
                    $(divFase).append(divFaseTitulo);

                    nTotalPartidos = $('#txtfaseid' + FaseActual).val();
                    $('#hfaseid' + FaseActual).val(nTotalPartidos);
                    for (nPartido = 1; nPartido <= nTotalPartidos; nPartido++) {

                        var d = document.createElement('div');
                        $(d).addClass('LlavesBox');
                        $(d).append('<h3>Partido ' + nPartido + '</h3>');

                        var dContenedorEquipos = $('<div/>', {
                            id: "idpartido_" + nPartido + "_" + FaseActual,
                            class: ' partido_' + nPartido + '_' + FaseActual + '  contenedor'
                        });
                        if (FaseActual == 1) {
                            $(dContenedorEquipos).addClass('contenedor_equipos');
                        }
                        else {
                            $(dContenedorEquipos).addClass('contenedor_equipos_vacio');
                        }

                        var hPartidoCurrent = $('<input/>', {
                            type: "hidden",
                            name: 'h_partido_' + nPartido + "_" + FaseActual,
                            id: "h_idpartido_" + nPartido + "_" + FaseActual,
                            value: ''
                        });

                        $(d).append(dContenedorEquipos);
                        $(d).append(hPartidoCurrent);

                        $(divFase).append(d);

                    }
                    $('#partidos').append(divFase);
                }
                crear_drag();
            }
        }

        function borrarLlaves() {
            $('#partidos').empty();
        }

        function borrar_fases() {
            $("#divFases").empty();
        }

        function crear_fases() {

            var numFases = $("#txt_cant_fase").val();
            nFases = numFases;
            $("#hCantFases").val(numFases);

            if (esEntero(nFases) == true && nFases > 0) {
                for (var i = 1; i <= numFases; i++) {
                    var sTxtFase = " Fase" + i + ": <input type='text' id='txtfaseid" + i + "' name='txtfase" + i + "' maxLength='2' class='input_tiny' value='' />";
                    var sHidenFase = "<input type='hidden' id='hfaseid" + i + "' name='hfase" + i + "' value='' />";
                    $('#divFases').append(sTxtFase);
                    $('#divFases').append(sHidenFase);
                }
                var BCrearFases = "<input type='button' id='btnCrearLlavesFases' value='Crear Llaves' class=' buton_css' />";
                $('#divFases').append(BCrearFases);
                $("#btnCrearLlavesFases").bind("click", function() {
                    crearLlaves();
                });

            }
        }

        function obtenerElementos() {
            var nFase = 1;
            var nLlave = 1;
            var numFases = $("#hCantFases").val();
            var nCantLlavesByFase = 0;
            
            for (nFase = 1; nFase <= numFases; nFase++) {
                nCantLlavesByFase = $("#hfaseid" + nFase).val();
                for (nLlave = 1; nLlave <= nCantLlavesByFase; nLlave++) {
                    var sorted = $('#idpartido_' + nLlave + '_' + nFase).sortable("toArray");
                    $("#h_idpartido_" + nLlave + '_' + nFase).val(sorted);
                }
            }
            return false;
        }


        function principal() {
            rellenar();// rellenar la lista de equipos disponibles
            borrar_fases();//borrar los txt de cantidad de partidos
            borrarLlaves();
            crear_fases();
            crear_drag();
        }
        $("#btnCrerFases").click(function() {
            principal();
        });

        function enumerar() {
            $('.contenedor_equipos  > .drag_div').each(function() {
                $(this).prepend("(" +
                        ($(this).index() + 1) + ") ");
            });
        }

        $("#frmLlaves").submit(function() {
            obtenerElementos();
        });
          

    });
</script>
<?php
include('sec/inc.footer.php');
?>