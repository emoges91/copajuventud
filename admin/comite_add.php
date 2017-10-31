<?php
include('conexiones/conec_cookies.php');

$nTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '1';

$sql = "select * from t_comite where TIPO=" . $nTipo;
$query = mysql_query($sql);
$cant = mysql_num_rows($query);

$sTitulo = '';
switch ($nTipo) {
    case '1':
        $sTitulo = 'Comite Disciplinario';
        break;
    case '2':
        $sTitulo = 'Comite Competencia';
        break;
    case '3':
        $sTitulo = 'Comite Competencia';
        break;
}

include('sec/inc.head.php');
?>
<h1>Agregar <?php echo $sTitulo; ?></h1>
<hr/>
<br/>

<form name="Directiva" action="comite_save.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="tipo" value="<?php echo $nTipo; ?>">
    <table border="0" align="center" width="1024px">
        <tr>
            <td>Nombre:* </td>
            <td><input type="text" name="nombre"></td>
        </tr>
        <tr>
            <td>Apellidos:* </td>
            <td><input type="text" name="apellidos"></td>
        </tr>
        <tr>
            <td>Cargo:*</td>
            <td> 
                <select name="cargo" style="width:100px">
                    <option label="Director" value="Director">Director</option>
                    <option label="Sub director" value="Sub Director">Sub director</option>
                    <option label="Secretario" value="Secretario">Secretario</option>
                    <option label="Suplente" value="Suplente">Suplente</option>
                    <option label="Vocero" value="Vocero">Vocero</option>
                </select>
            </td> 
        </tr>
        <tr>
            <td>Foto: </td>
            <td><input type="file" name="foto"></td>  
        </tr>
    </table>
    <br/><br/>
    <div>
        <input type="submit" Value="Guardar"/>
        <input type="button" Value="Cancelar" onclick="document.location.href = 'comites.php';"/>
    </div>
    <p>Los campos con asterisco (*) son requeridos</p>
</form>

<?php
include('sec/inc.footer.php');
?>