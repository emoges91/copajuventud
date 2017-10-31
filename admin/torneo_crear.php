<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');
?>
<body>
    <h1>Crear nuevo torneo</h1>
    <h2>Paso 1</h2>
    <hr/>
    <form name="formulario" action="torneo_crear_guardar.php" enctype="multipart/form-data" method="post" onSubmit="obtenerElementos();">
        <table>
            <tr>
                <td>Nombre del torneo</td>
                <td><input name="NOMBRE" type="text" value="" maxlength="50" size="50px"/></td>
            </tr>
            <tr>
                <td>Edicion</td>
                <td><input name="EDICION" type="text" value="<?php echo date("Y"); ?>"/></td>
            </tr>
            <tr>
                <td>Fase de Inicio</td>
                <td>
                    <input name="FASE" type="radio" value="1" checked /> Grupos
                    <br/>
                    <input name="FASE" type="radio" value="2"/> Llaves
                </td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <input type="submit" name="" value="Guardar" class="buton_css"/>
                    <input type="button" Value="Cancelar" onclick="history.go(-1);" class="buton_css">
                </td>
            </tr>
            
        </table>
    </form>
</body>
</html>
<?php
include('sec/inc.footer.php');
?>