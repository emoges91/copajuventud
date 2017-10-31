<?php
include('conexiones/conec_cookies.php');

$sql = "select * from t_patrocinador";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);

include('sec/inc.head.php');
?>
<h2>Patrocinadores</h2>
<hr/>
<br/>
<div width="100%" class="right">
    <a class="buton_css" href="./patrocinador_add.php">Agregar</a>
</div>
<div class="clear"></div>
<br/>
<table class=" table_grupos table_content">
    <tr>
        <td> <b>Acciones</b> </td>
        <td><b>Empresa</b></td>
        <td><b>Direccion web</b></td>
        <td><b>Mostrar</b> </td>
        <td><b>Imagen</b></td>
    </tr>
    <?php
    while ($row = mysql_fetch_assoc($query)) {
        $sMostrar = 'SI';
        if ($row['MOSTRAR'] == '0') {
            $sMostrar = 'NO';
        }
        echo '
                <tr>
                    <td>
                        <a href="patrocinador_delete.php?id=' . $row['ID'] . '"onclick="javascript: return sure();">
                            Eliminar
                        </a>
                        ||
                        <a href="patrocinador_editar.php?id=' . $row['ID'] . '&tipo=' . $row['EMPRESA'] . '&direccion=' . $row['URL'] . '">
                            Editar
                        </a>
                    </td>
                    <td>' . $row['EMPRESA'] . '</td>
                    <td>
                            <a href="http://' . $row['DIRECCION'] . '" target="_new">' . $row['DIRECCION'] . '</a>
                    </td>
                    <td><a href="patrocinador_mostrar.php?id=' . $row['ID'] . '"> ' . $sMostrar . '</a> </td>
                    <td>
                            <img src="' . $row['URL'] . '" width="50" height="60">
                    </td>
                </tr>';
    }
    ?>
</table>
<?php
include('sec/inc.footer.php');
?>
