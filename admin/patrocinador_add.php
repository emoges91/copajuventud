
<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');


$sql = "select * from t_patrocinador";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
?>
<h1>Agregar Patrocinador</h1>
<hr/>
<br/>
<form action="patrocinador_save.php" method="post" enctype="multipart/form-data">
    <table >
        <tr>
            <td>Empresa:*</td>
            <td><input type="text" name="empresa"></td>
        </tr>
        <tr>
            <td>Direccion Web:</td>
            <td><input type="text" name="direccion"></td>
        </tr>
        <tr>
            <td>Mostar:*</td>
            <td><input type="checkbox"  name="mostrar" value="1"></td>
        </tr>
        <tr>
            <td>Imagen:*</td>
            <td><input type="file" name="foto"></td>
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar">
        <input type="button" Value="Atras" onclick="document.location.href = './patrocinador.php';">
    </div>
    <p>Los campos con asterisco (*) son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>
