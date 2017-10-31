<?php
include('conexiones/conec_cookies.php');


include('sec/inc.head.php');
?>
<h1>Agregar Album</h1>
<hr>
<br/>

<form action="album_save.php" enctype="multipart/form-data" method="post">
    <table align="center">
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre"></td>
        </tr>
        <tr>
            <td>Descripcion:</td>
            <td><input type="text" name="desc"></td>	
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" value="Cancelar" onclick="document.location.href = 'album.php';"/>
    </div> 
</form>

<?php
include('sec/inc.footer.php');
?>