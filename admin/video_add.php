<?php
include('conexiones/conec_cookies.php');


include('sec/inc.head.php');
?>
<h1>Agregar Video</h1>
<hr>
<br/>
<form action="video_save.php" enctype="multipart/form-data" method="post">
    <table align="center">
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nom"></td>
        </tr>
        <tr>
            <td>Descripcion: </td>		
            <td><input type="text" name="des"</td>
        </tr>
        <tr>
            <td>URL Youtube: </td>
            <td><input type="text" name="url"></td>	
        </tr> 
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" value="Cancelar" onclick="document.location.href = 'videos.php';">
    </div> 
</form> 
<?php
include('sec/inc.footer.php');
?>
