<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$sPersonaID = (isset($_GET['id'])) ? $_GET['id'] : 0;


$sql = "SELECT * FROM t_personas WHERE ID = '" . $sPersonaID . "'";
$query = mysql_query($sql, $conn);

$row = mysql_fetch_assoc($query)
?>
<h1>Editar Jugador</h1>
<form action="guarda_jugadores_editados.php" method="post">
    <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">
    <table >
        <tr>
            <td>Nombre*</td>
            <td><input type="text" name="NOMBRE" value= "<?php echo $row['NOMBRE']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td>Primer apellido*</td>
            <td><input type="text" name="APELLIDO1" value= "<?php echo $row['APELLIDO1']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td>Segunod apellidos*</td>
            <td><input type="text" name="APELLIDO2" value= "<?php echo $row['APELLIDO2']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td>Cedula*</td>
            <td><input type="text" name="CED" value= "<?php echo $row['CED']; ?>" maxlength="20"></td>
        </tr>
        <tr>
            <td>Direccion*</td>
            <td><input type="text" name="DIR" value= "<?php echo $row['DIR']; ?>" maxlength="50"></td>
        </tr>
        <tr>
            <td>Telefono</td>
            <td><input type="text" name="TEL" value= "<?php echo $row['TEL']; ?>" maxlength="10"></td>
        </tr>
        <tr>
            <td>Activo*</td>
            <td><input type="checkbox" name="ACTIVO" value="1" <?php if ($row['ACTIVO'] == 1) echo 'checked'; ?>/></td>
        </tr>
    </table>
    <table >
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Guardar">  
                <input type="button" Value="Cancelar" onclick="document.location.href = '<?php echo ' personas.php?id='; ?>';"></td>
        </tr>
    </table>
    <p>Los campos con asterisco(*)son requeridos</p>
</form>

<?php
include('sec/inc.footer.php');
?>