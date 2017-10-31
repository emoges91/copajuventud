<table id="Tabla_01" width="1062" height="453" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
    <tr>
        <td style="background:url(img/otras_img/otro_03.png) repeat-y; width:1035px; height:284px;" valign="top">
            <?php
            if ($_GET['id'] == 1) {
                $nombre = "Erick Josue Monge Solis";
                $correo = "monge.erick@Gmail.com";
            }
            if ($_GET['id'] == 2) {
                $nombre = "Marlon Rodriguez Hernandez";
                $correo = "marlonyazit@yahoo.es";
            }
            if ($_GET['id'] == 3) {
                $nombre = "Luis Miguel Calderon Salazar";
                $correo = "lmcsalazar@Gmail.com";
            }
            ?>
            <p align="center"><font size="+2">Enviar correo a <?php echo $nombre; ?></font></p>   	
            <form action="enviar.php" method="post" enctype="multipart/form-data">
                <table align="center" border="0">
                    <tr>
                        <td>Nombre: (*) </td>
                        <td><input type="text" name="nombre"  size="30"></td>
                    </tr>
                    <tr>
                        <td>Correo Electornico: (*) </td>
                        <td><input type="text" name="mail" size="30">
                        </td>
                    </tr>
                    <tr>
                        <td>Telefono: (*) </td>
                        <td><input type="text" name="tele" size="30">
                        </td>
                    </tr>
                    <tr>
                        <td>Empresa: </td>
                        <td><input type="text" name="empresa" size="30">
                        </td>
                    </tr>
                    <tr>
                        <td>Asunto: (*)</td>
                        <td><textarea name="DC" id="DC" rows="12"></textarea></td>
                    </tr>
                    <input type="hidden" value="<?php echo $correo; ?>" name="correodes" />
                </table>

                <table border="0" align="center">
                    <td><input type="submit" Value="Enviar">
                        <input type="button" Value="Atras" onclick="document.location.href = 'index.php';">
                        <input type="reset" value="Limpiar Formulario" size="8">
                    </td>
                    </tr>
                </table>
                <center>Los campos con asterisco (*) son requeridos</center>

            </form>
        </td>
    
    </tr>
   
</table>