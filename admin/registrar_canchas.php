<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php'); 
?>
<h1>Registro de canchas</h1>
<form action="canchas_guardar.php" method="post">
    <table  border="0" >
        <tr>
            <td>Nombre de la cancha*:</td>
            <td><input type="text" name="NOMBRE"></td>
        </tr>
        <tr>
            <td>Direccion:</td>
            <td><input type="text" name="DIRECCION"></td>
        </tr>
        <tr>
            <td></td>    
            <td >
                <input type="submit" Value="Guardar">
            </td>
        </tr>
    </table>
    <p>Los campos con asterisco (*) son requeridos</p>

</form>
<hr>
<table border="0"  width="100%" class="table_content">
    <tr>
        <td><b>Acciones</b> </td>
        <td><b>Cancha</b>  </td>
        <td><b>Dirección</b>  </td>
    </tr>
    <?php
    /*     * prueba* */
    $sql = "select * from t_cancha";
    $query = mysql_query($sql, $conn);
    $cant = mysql_num_rows($query);

    if ($cant > 0) {
        while ($row = mysql_fetch_assoc($query)) {
            echo '
                <tr>
                    <td>
                    <a href="canchas_eliminar.php?id=' . $row['ID'] . '"onclick="javascript: return sure();">Eliminar</a>
                    || <a href="canchas_editar.php?id=' . $row['ID'] . '">Editar</a>
                    </td>
                    <td>' . $row['NOMBRE'] . '</td>
                    <td>' . $row['DIR'] . ' </td>
            </tr>';
        }
        echo '
	   ';
    } else {
        echo '<tr><td colspan="3">No hay Canchas registradas</td></tr>';
    }
    ?>
</table>
<?php
include('sec/inc.footer.php');
?>
