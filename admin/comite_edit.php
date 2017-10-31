<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php');

$sql = "SELECT * FROM t_comite WHERE ID = '" . $_GET['id'] . "'";
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);
?>
<h1>Editar Directiva</h1>
<h2><?php echo $row['CARGO']; ?></h2>
<hr>
<br/> 

<form action="comite_edit_save.php" name="Editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
    <input type="hidden" name="tipo" value="<?php echo $row['TIPO']; ?>" >
    <input type="hidden" name="cargo" value= "<?php echo $row['CARGO']; ?>">
    <input type="hidden" name="nomb_foto" value= "<?php echo $_GET['nombre']; ?>">
    <input type="hidden" name="tipo_dir" value="<?php echo $_GET['tipo']; ?>">
    <input type="hidden" name="url" value="<?php echo $_GET['url']; ?>">
    <table  >
        <tr>
            <td>Nombre*</td>
            <td><input type="text" name="nombre" value= "<?php echo $row['NOMBRE']; ?>"></td> 
        </tr>
        <tr>
            <td>Apellidos*</td>
            <td><input type="text" name="apellidos" value= "<?php echo $row['APELLIDOS']; ?>"></td>
        </tr>
        <tr>
            <td>Foto: </td>
            <td><input type="file" name="foto"></td>
        </tr>
    </table>
    <br/>   <br/>
    <div>
        <input type="submit" value="Guardar">
        <input type="button" Value="Cancelar" onclick="document.location.href = 'comites.php';">
    </div>

    <p>Los campos con asterisco(*)son requeridos</p>
</form>
<?php
include('sec/inc.footer.php');
?>


