<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');
?>


<?php
$sql = "SELECT * FROM t_cancha WHERE ID = '" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn);

while ($row = mysql_fetch_assoc($query)) {
    ?>

    <h1>Editar Canchas</h1>
    <form action="guarda_canchas_editadas.php" method="post">
        <table >
            <tr>
                <td>Nombre*</td>
                <td><input type="text" name="NOMBRE" value= "<?php echo $row['NOMBRE']; ?>"></td>
            <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">
            </tr>
            <tr>
                <td>Direccion*</td>
                <td><input type="text" name="DIR" value= "<?php echo $row['DIR']; ?>"></td>
            </tr>
            <tr>
                <td></td>
            <tr>
                <td><input type="submit" value="Guardar"></td>
                <td><input type="button" Value="Cancelar" onclick="document.location.href = 'registrar_canchas.php';"></td>
            </tr>
        </table>
        <p>Los campos con asterisco(*)son requeridos</p>
    </form>
    <?php
}
include('sec/inc.footer.php');
?>
?>