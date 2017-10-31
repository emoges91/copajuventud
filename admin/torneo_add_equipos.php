<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';

$oTorneo = new torneo();

$nTorneoID = (isset($_GET['id_tor'])) ? $_GET['id_tor'] : 0;
$fila = $oTorneo->getTorneoByID($nTorneoID);

$sql = "select * from t_equipo e ORDER BY e.NOMBRE ASC";
$query = mysql_query($sql);

include('sec/inc.head.php');
?>


<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR']; ?> - Agregar Equipos</h1>
<h2>Paso 2</h2>
<hr/>

<div class="equipos_columna">
    <h2>Equipos disponibles</h2>
    <div>
        <input type="text" id="filter_input" placeholder="Buscar Equipo" style="height: 34px;">
    </div>
    <br/>
    <div id="list_to_filter" class=" contenedor_equipos">                 
        <?php
        while ($row = mysql_fetch_assoc($query)) {
            ?>
            <div class="drag_div" id="<?php echo 'e_' . $row["ID"]; ?>" >
                <?php echo ' * ' . $row['NOMBRE']; ?>
                <input type="hidden" name="equipos[]" value="<?php echo $row["ID"]; ?>"/>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="equipos_columna">
    <h2>Equipos Participantes</h2>
    
    <form name="formulario" action="torneo_add_equipos_guardar.php" enctype="multipart/form-data" method="post" onSubmit="obtenerElementos();">
        <div>
            <input type="submit"  value="Guardar" class="buton_css">
        </div>
        <br/>
        <div  id="grupos" class="contenedor_equipos participantes">
        </div>
        <input type="hidden" name="torneo_id" value="<?php echo $nTorneoID;  ?>"/>
    </form>
</div>

<?php
include('sec/inc.footer.php');
?>