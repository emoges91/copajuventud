<?php
include('conexiones/conec_cookies.php');

$dToday = date('Y-m-d');

include('sec/inc.head.php');
?>
<h1>Agregar Noticia</h1>
<hr>
<br/>
<form action="noticias_save.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table  border="0">
        <tr>
            <td>Titulo:*</td>
            <td><input type="text" name="TITULO" size="60"></td>
        </tr>
        <tr>
            <td>Fecha:*</td>
            <td>
                <input name="FECHA" type="date" value="<?php echo $dToday; ?>"  autocomplete="off" size="19">  
            </td>
        </tr>
        <tr>
            <td>Descripcion corta:*</td>
            <td><textarea name="DC" id="DC"></textarea></td>
        </tr>
        <tr>
            <td>Destacada:*</td>
            <td><input type="checkbox" name="featured" value="1" /></td>
        </tr>
        <tr>
            <td>Fotografia(420px x 266px):</td>
            <td><input type="file" name="foto"></td>
        </tr>
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" Value="Cancelar" onclick="document.location.href = 'noticias.php';"/>
    </div> 
    <p>Los campos con asterisco (*) son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>
