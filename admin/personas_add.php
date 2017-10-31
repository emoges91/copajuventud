
<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

?>
<h1>Agregar persona</h1>
<form action="guarda_jugadores.php" enctype="multipart/form-data" method="post">
    <table >
        <tr>
            <td>Nombre*</td>
            <td><input type="text" name="NOMBRE" maxlength="50"></td>
        </tr>
        <tr>
            <td>Primer apellido*</td>
            <td><input type="text" name="APELLIDO1" maxlength="50"></td>
        </tr>
        <tr>
            <td>Segundo apellidos*</td>
            <td><input type="text" name="APELLIDO2" maxlength="50"></td>
        </tr>
        <tr>
            <td>Cedula*</td>
            <td><input type="text" name="CED" maxlength="20"></td>
        </tr>
        <tr>
            <td>Direccion*</td>
            <td><input type="text" name="DIR" maxlength="50"></td>
        </tr>
        <tr>
            <td>Telefono</td>
            <td><input type="text" name="TEL" maxlength="10"></td>
        </tr>
        <tr>
            <td>Activo*</td>
            <td><input type="checkbox" name="ACTIVO" value="YES" checked></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Guardar"></td>
        </tr>
    </table>
    <p>Los campos con asterisco (*) son requeridos</p>

</form>
<?php

include('sec/inc.footer.php');
?>
