<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';
include 'module/personas/personas.php';
include 'module/equipos/equipos.php';
include 'module/equipos/jugadores.php';

$oTorneo = new torneo();
$oPersona = new personas();
$oEquipo = new equipos();

$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$aTorneo = $oTorneo->getTorneoByID($sTorVerID);
$aEquipo = $oEquipo->getByID($nEquiID);

include('sec/inc.head.php');
include('sec/inc.menu.php');
include('sec/inc.menu_equi.php');
?>
<h1><?php echo $aTorneo['NOMBRE'] . ' ' . $aTorneo['YEAR']; ?></h1>
<hr/>

<script languaje="javascript">
    function Deshabilitaasistente(form) {
        if (form.DT.checked == true) {
            form.ASISTENTE.checked = false;
        }
    }

    function Deshabilitadt(form) {
        if (form.ASISTENTE.checked == true) {
            form.DT.checked = false;
        }
    }

    function Deshabilitasr(form) {
        if (form.REPRESENTANTE.checked == true) {
            form.SUPLENTE.checked = false;
        }
    }

    function Deshabilitarepresentante(form) {
        if (form.SUPLENTE.checked == true) {
            form.REPRESENTANTE.checked = false;
        }
    }
</script>
<script type="text/javascript" src="./js/custom.js" ></script>

<div class="equipo_detail">
    <img class="left" src="<?php echo $aEquipo['url']; ?>" width="150px">

    <div  class="left">
        <h2><?php echo $aEquipo['EQ_NOMBRE']; ?></h2>
        <h5>
            Estado:
            <?php
            if ($aEquipo['ACTIVO'] == 1) {
                echo 'Activo';
            } else {
                echo 'No activo';
            }
            ?>
        </h5> 
        <p>Cancha oficial: <?php echo $aEquipo['CO_NOMBRE']; ?> </p>
        <p>Cancha alterna: <?php echo $aEquipo['CA_NOMBRE']; ?>  </p>
    </div>
    <div class="clear"></div>
</div> 

<div>
    <!-- Main Title -->
    <div class="icon"></div>
    <h1 class="title">Registrar Jugador</h1>
    <h5 class="title">(Busqueda de personas registradas)</h5>
    <!-- Main Input -->
    <input id="search" type="text" />
    <!-- Show Results -->
    <ul id="results"></ul>
</div>

<br/>
<hr/>
<!--fin-->


<form action="torneo_jugador_guardar.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="ID" value="" id="PerID">
    <input type="hidden" name="EQUIPO" value="<?php echo $nEquiID; ?>">
    <input type="hidden" name="ACTION" value="add">
    <table > 
        <tr>
            <td>Nombre:</td>
            <td><input type="text"  name="NOMBRE" disabled="disabled" value="" id="PerName"/></td>
        </tr>
        <tr>
            <td>Primer apellido:</td>
            <td><input type="text" name="APELLIDO1" disabled="disabled" value="" id="PerApe1" /></td>
        </tr>
        <tr>
            <td>Segundo apellidos:</td>
            <td><input type="text" name="APELLIDO2" disabled="disabled" value="" id="PerApe2"/></td>
        </tr>
        <tr>
            <td>Cedula:</td>
            <td><input type="text" name="CED" disabled="disabled" value="" id="PerCED"/></td>
        </tr> 
    </table>
    <br/>
    <h2>Cargos</h2>
    <table >
        <tr>
            <td colspan="2"><input type="checkbox" name="JUGADOR" value="YES" id="CHJug">Jugador</td>
        </tr>
        <tr>
            <td colspan="2"><input type="checkbox" name="DT" value="YES" onClick="Deshabilitaasistente(this.form)" id="CHDT">Director Tecnico</td>
        </tr>
        <tr>
            <td colspan="2"><input type="checkbox" name="ASISTENTE" value="YES" onClick="Deshabilitadt(this.form)" id="CHDT_Asis">Asistente cuerpo tecnico</td>
        </tr>
        <tr>
            <td colspan="2"><input type="checkbox" name="REPRESENTANTE" value="YES" onClick="Deshabilitasr(this.form)" id="CHRep">Representante</td>
        </tr>
        <tr>
            <td colspan="2"><input type="checkbox" name="SUPLENTE" value="YES" onClick="Deshabilitarepresentante(this.form)" id="CHSup">Suplente Representante</td>
        </tr>
    </table>
    <br/><br/>
    <div>
        <input type="submit" value="Guardar" class="buton_css">
        <input type="button" Value="Cancelar" onclick="document.location.href = '<?php echo 'torneo_equipo_detalle.php?id=' . $nEquiID; ?>';" class="buton_css">
    </div>

    <p>El campo con asterisco (*) son requerido</p>
</form>
<?php
include('sec/inc.footer.php');
?>
