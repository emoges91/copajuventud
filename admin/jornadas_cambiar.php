
<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/torneos/eventos.php';
include 'module/torneos/jornadas.php';
include_once('FPHP/funciones.php');

$sNumGroup = (isset($_GET['NUM_GRU'])) ? $_GET['NUM_GRU'] : '';

$oTorneo = new torneo();
$oEventos = new eventos();
$oJornadas = new jornadas();

$fila = $oTorneo->getTorneoByID($sTorVerID);
$aEvento = $oEventos->getEvenByInstancia($sTorVerID, '1');
$aJornadas = $oJornadas->getJornadasGruposByGrupo($aEvento['ID'], $sNumGroup);
$cant_jor = $oJornadas->getMaxJornadas($aEvento['ID'], $sNumGroup);


$comparar_jornadas = '';

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>

<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?></h1>
<h2>Cambiar orden de jornadas de <?php echo $aEvento['NOMBRE']; ?></h2>



<form name="formulario" action="jornadas_cambiar_guardar.php" enctype="multipart/form-data" method="post" onSubmit="return ordenJornadas();" id="formulario">
    <input name="HidTorneo" type="hidden" value="<?php echo $fila['ID']; ?>" />

    <div width="100%" class="right">
        <input type="submit"  class="buton_css" value="Guardar"/>
        <input type="button"  class="buton_css" onclick="document.location.href = 'jornadas_grupos.php';" value="Cancelar">
    </div>
    <div class="clear"></div>
    <hr/>

    <table cellpadding="0" cellspacing="0" class="jornadas">
        <?php
        $nCantJor = count($aJornadas);
        for ($e = 0; $e < $nCantJor; $e++) {

            //--------------------mostrar el nombre de la jornada----------
            if ($aJornadas[$e]['NUM_JOR'] <> $comparar_jornadas) {
                ?>		

                <tr>
                    <td colspan="10" id="Njornadas2" align="center" style="border-right:1px solid #ddd;">                        	
                        <select name="CbBPosicion<?php echo $aJornadas[$e]['NUM_JOR']; ?>" 
                                id="IdCbBPosicion<?php echo $aJornadas[$e]['NUM_JOR']; ?>"
                                style="float:left;" title="Orden jornada" 
                                onchange="cambiarCombo('IdCbBPosicion<?php echo $aJornadas[$e]['NUM_JOR']; ?>',<?php echo $aJornadas[$e]['NUM_JOR']; ?>);"> 
                                    <?php
                                    For ($a = 1; $a <= $cant_jor; $a++) {
                                        if ($a == $aJornadas[$e]['NUM_JOR']) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = '';
                                        }
                                        echo '<option value="' . $a . '" ' . $checked . ' >' . $a . '</option>';
                                    }
                                    ?>
                        </select>
                        Jornada <?php echo $aJornadas[$e]['NUM_JOR']; ?>
                    </td> 
                </tr>
                <tr>
                    <th>Equipo Casa</th>
                    <th>Marcador</th>
                    <th></th>
                    <th>Equipo visita</th>
                    <th>Marcador</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th style="border-right:1px solid #ddd;">Grupo</th>
                </tr>
                <?php
            }// fin de mostrar encabezado jornada


            ?>
            <tr>
                <td align="center" ><?php echo $aJornadas[$e]['NOM_CASA']; ?></td>
                <td align="center" ><?php echo $aJornadas[$e]['MAR_CASA']; ?></td>
                <td align="center" >Vrs</td>
                <td align="center" ><?php echo $aJornadas[$e]['NOM_VISITA']; ?></td>
                <td align="center" ><?php echo $aJornadas[$e]['MAR_VISITA']; ?></td>
                <td align="center" ><?php echo $aJornadas[$e]['FECHA']; ?></td>
                <td align="center" ><?php echo $aJornadas[$e]['TJS_NOMBRE']; ?></td>
                <td align="center"><?php echo $aJornadas[$e]['GRUPO']; ?></td>
            </tr>    
            <?php
            $comparar_jornadas = $aJornadas[$e]['NUM_JOR'];

            $idsJornas = $aJornadas[$e]['JOR_ID'] . ',' . $idsJornas;
            if ($aJornadas[$e + 1]['NUM_JOR'] <> $comparar_jornadas) {
                echo '<input type="hidden" name="HidIdJornadas' . $aJornadas[$e]['NUM_JOR'] . '" value="' . $idsJornas . '">';
                $idsJornas = '';
            }
        }
        ?>
        <input type="hidden" name="total_jornadas" value="<?php echo $comparar_jornadas; ?>">
    </table>
</form>
<script type="text/javascript" >
    var total_jornadas =<?php echo $comparar_jornadas; ?>;
    var array_jornadas = new Array();
<?php
for ($j = 1; $j <= $comparar_jornadas; $j++) {
    echo "array_jornadas[" . $j . "]=" . $j . ";";
}
?>

    function cambiarCombo(combo, num) {
        var CbBOrden = document.getElementById(combo);
        var nuevoValor = CbBOrden.options[CbBOrden.selectedIndex].value;
        var valorAnterior = array_jornadas[num]

        for (var i = 1; i <= total_jornadas; i++) {
            if (nuevoValor == array_jornadas[i]) {
                var CbBcomboBusqueda = document.getElementById('IdCbBPosicion' + i);
                CbBcomboBusqueda.selectedIndex = (valorAnterior - 1);
                array_jornadas[i] = valorAnterior;
            }
        }
        array_jornadas[num] = nuevoValor;
    }
</script>
<?php
include('sec/inc.footer.php');
?>
