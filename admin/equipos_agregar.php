<?php
include ('conexiones/conec_cookies.php');
include('sec/inc.head.php'); 
?>
<h1>Agregar nuevo equipo</h1>
<form name="formulario" action="equipos_ingresar.php" enctype="multipart/form-data" method="post">

    <table border="0" >
        <tr>
            <td>Nombre: *</td>
            <td><input type="text" name="nombre"></td>
        </tr>
        <tr>
            <td>Activo: </td>
            <td><input type="checkbox" name="activo" value="YES" checked ></td>
        </tr>
        <tr>
            <td>Cancha oficial: </td>
            <td>
                <select name="canofi" id="cancha_ofi">
                    <option value=""></option>
                    <?php
                    $num_registros = "select * from t_cancha";
                    $consulta = mysql_query($num_registros);
                    while ($fila = mysql_fetch_array($consulta)) {
                        echo "<option value='" . $fila["ID"] . "' >" . $fila["NOMBRE"] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Cancha alterna: </td>
            <td>
                <select name="canalt" id="cancha_alt">
                    <option value=""></option>
<?php
$num_registros = "select * from t_cancha";
$consulta = mysql_query($num_registros);
while ($fila = mysql_fetch_array($consulta)) {
    echo "<option value='" . $fila["ID"] . "'>" . $fila["NOMBRE"] . "</option>";
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Escudo del equipo: </td>
            <td><input type="file" name="logo"></td>
        </tr>
    </table>

    <table border="0" >
        <tr>	
            <td>
                <input type="submit" Value="Guardar">
                <input type="reset" value="Limpiar formulario">
            </td>
        </tr>
    </table>
    <center>Los campos con asterisco (*) son requeridos</center>
</form>
<?php
include('sec/inc.footer.php');
?>