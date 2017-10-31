<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/equipos/equipos.php';

$nTorneoID = (isset($_GET['id_tor'])) ? $_GET['id_tor'] : 0;

$oTorneo = new torneo();
$oEquipos = new equipos();
$fila = $oTorneo->getTorneoByID($nTorneoID);

$aEquipos = $oEquipos->getEquiposByTorneo($nTorneoID);


include('sec/inc.head.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> -  Crear Grupos</h1>
<h2>Paso 3</h2>
<hr/>
<form name="formulario" action="torneo_grupos_guardar.php" enctype="multipart/form-data" method="post" id="frmGrupos">
    <input type="hidden" name="TORNEO_ID" value="<?php echo $nTorneoID; ?>"/>
    <div>
        <input type="submit" value="Guardar Grupos" class="buton_css right" />
    </div>
    <div>
        Grupos
        <input name="CAN_GRU" type="text" value="0" placeholder="Digite aqui " id="txtCantGrupos"/>
        <input id="btnCrearGrupos" type="button" value="Crear grupos">
    </div>

    <table>
        <tr>
            <td class="align_top w_1">
                <h2>Equipos disponibles</h2>
                <div  id="lista" class="lista contenedor_equipos" >                   
                    <?php
                    $nEquipos = count($aEquipos);
                    for ($index = 0; $index < $nEquipos; $index++) {
                        echo '<div class="drag_div"  id="e_' . $aEquipos[$index]["EQ_ID"] . '" >* ' . $aEquipos[$index]['EQ_NOMBRE'] . '</div>';
                    }
                    ?>
                </div>
            </td>
            <td class="align_top">
                <h2>Grupos</h2>
                <div id="grupos"></div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    var cantidad_grupos = 0;

    var arra_items = new Array();
    var arra_nom = new Array();
<?php
$i = 0;
$nEquipos = count($aEquipos);
for ($index = 0; $index < $nEquipos; $index++) {
    echo '
        arra_items[' . $i . ']=' . $aEquipos[$index]["EQ_ID"] . ';
        arra_nom[' . $i . ']="* ' . $aEquipos[$index]['EQ_NOMBRE'] . '";
    ';
    $i++;
}
?>

    $(function() {
        // your code goes here
        function rellenar() {
            var i;
            var lista = $("#lista");
            for (i = 0; i < arra_items.length; i++) {
                var strDiv = '<div class="drag_div" id="' + "e_" + arra_items[i] + '">' + arra_nom[i] + '</div>';
                var contenedores = $('#e_' + arra_items[i]);
                contenedores.remove();
                lista.append(strDiv);
            }
        }

        function crear_drag() {
            $(".contenedor_equipos").sortable({
                connectWith: ".contenedor_equipos",
                placeholder: "Arrastre aqui"
            }).disableSelection();
        }
        crear_drag();

        function crearGrupos() {
            rellenar();
            borrar_lista();
            cantidad_grupos = $('#txtCantGrupos').val();
            var i;
            for (i = 1; i <= cantidad_grupos; i++) {
                var d = document.createElement('div');
                var n_input = '<input type="hidden" name="' + 'h_grupo' + i + '" id="' + "h_idgrupo" + i + '" value=""/>';
                var elemento = '<div class="contenedor_equipos Grupo' + i + '" id="' + "idGrupo" + i + '"></div>';
                $(d).append('<h3>' + "Grupo " + i + '</h3>' + n_input + elemento);
                $(d).attr('id', "grupoBox" + i);
                $(d).addClass('GroupsBox');
                $('#grupos').append(d);
            }
            crear_drag();
        }
        $("#btnCrearGrupos").click(function() {
            crearGrupos();
        });


        function borrar_lista() {
            if (cantidad_grupos > 0) {
                var i;
                for (i = 1; i <= cantidad_grupos; i++) {
                    $("#grupoBox" + i).remove();
                }
            }
        }

        function obtenerElementos() {
            var i = 1;
            for (i = 1; i <= cantidad_grupos; i++) {
                var sorted = $('#idGrupo' + i).sortable("toArray");
                $("#h_idgrupo" + i).val(sorted);
            }
            $('#txtCantGrupos').val(cantidad_grupos);
            return false;
        }

        $("#frmGrupos").submit(function() {
            obtenerElementos();
        });



    });

</script>
<?php
include('sec/inc.footer.php');
?>