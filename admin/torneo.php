<?php
include('conexiones/conec_cookies.php');

$sql = "select * from t_torneo order by ID DESC";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);
$numero = 0;

include('sec/inc.head.php');
?>

<h1>Administracion del torneo</h1>
<h2> Ediciones </h2>
<hr/>

<form name="formulario" action="torneo_crear.php" enctype="multipart/form-data" method="post">
    <input type="submit" class="buton_css" value="Crear un nuevo torneo"/>
</form>
<br/>
<?php

if ($cant > 0) {
    ?>   
    
    <table  width="100%" class="table_content">
        <tr>
            <td width="110px" ><b>Acciones</b> </td>
            <td width="30px"><b>ID</b> </td>
            <td><b>Nombre</b></td>
            <td><b>Edicion</b> </td>
            <td><b>Mostrar</b> </td>
        </tr>
        <?php
        while ($row = mysql_fetch_assoc($query)) {
            $sMostrar = 'SI';
            if ($row['MOSTRAR'] == '0') {
                $sMostrar = 'NO';
            }
            ?>
            <tr>
                <td >
                    <a href="torneo_eliminar.php?id=<?php echo $row['ID']; ?>" onclick="javascript: return sure();">				
                        Eliminar</a>
                    || <a href="torneo_editar.php?id=<?php echo $row['ID']; ?>">Editar</a>
                    || <a href="torneo_tabla_general.php?tor_ver_id=<?php echo $row['ID']; ?>">Ver</a>
                    
                </td>
                <td><?php echo $row['ID']; ?> </td>
                <td><?php echo $row['NOMBRE']; ?>  </td>
                <td> <?php echo $row['YEAR']; ?> </td>
                <td><a href="torneo_mostrar.php?id=<?php echo $row['ID']; ?>"> <?php echo $sMostrar; ?></a> </td>
            </tr>

            <?php
        }
        ?>
    </table>

    <?php
} else {
    echo '<center>Lista de torneos vacia</center>';
}
?>

<?php
include('sec/inc.footer.php');
?>