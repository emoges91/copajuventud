<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$sql = "SELECT * FROM t_equipo WHERE ID = '" . $nEquiID . "'";
$query = mysql_query($sql, $conn);

while ($row = mysql_fetch_assoc($query)) {
    ?>

    <h1>Editar equipo</h1>
    <form name="formulario" action="guaredit_equi.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
        <table border="0" >
            <tr>
                <td>Nombre: *</td>
                <td><input type="text" name="nombre" value="<?php echo $row['NOMBRE']; ?>"></td>
            </tr>
            <tr>
                <td>Activo: </td>
                <td><input type="checkbox" name="activo" value="YES" <?php if ($row['ACTIVO'] == 1) echo 'checked'; ?> /></td>
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
                            echo "<option value='" . $fila["ID"] . "' ";
                            if ($row["CAN_OFI"] == $fila["ID"]) {
                                echo "selected='selected'";
                            }
                            echo ">";
                            echo $fila["NOMBRE"];
                            echo "</option>";
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
                            echo "<option value='" . $fila["ID"] . "' ";
                            if ($row["CAN_ALT"] == $fila["ID"]) {
                                echo "selected='selected'";
                            }
                            echo ">";
                            echo $fila["NOMBRE"];
                            echo "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Escudo del equipo: </td>
                <td><input type="file" name="logo" value="<?php echo $row['URL']; ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" Value="Guardar">
                </td>
            </tr>
        </table>
        <p>Los campos con asterisco (*) son requeridos</p>
    </form>

    <?php
}
include('sec/inc.footer.php');
?>