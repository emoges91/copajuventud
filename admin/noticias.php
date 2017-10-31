<?php
include('conexiones/conec_cookies.php');

$sql = "select * from t_noticias";
$query = mysql_query($sql);

include('sec/inc.head.php');
?>
<h1>Noticias</h1>
<hr>

<div width="100%" class="right">
    <a href="noticias_add.php" class="buton_css">Añadir Nueva</a>
</div>
<div class="clear"></div>
<br/>

<table border="0" align="center" width="100%">
    <tr bgcolor="#000000" style="color: #ffffff; text-align: center">
        <td> <b>Acciones</b>  </td>
        <td> <b>Titulo</b> </td>
        <td> <b>Descripcion corta</b> </td>
        <td> <b>Destacada</b> </td>
        <td> <b>Imagen</b>  </td>
    </tr>
    <?php
    while ($row = mysql_fetch_assoc($query)) {
        $sFeatured = 'SI';
        if ($row['FEATURED'] == '0') {
            $sFeatured = 'NO';
        }
        echo '
            <tr>
                <td>
                    <a href="noticias_delete.php?id=' . $row['ID'] . '"onclick="javascript: return sure();">Eliminar</a>
                    || 
                    <a href="noticias_editar.php?id=' . $row['ID'] . '">Editar</a>
                </td>
                <td> <span > ' .$row['TITULO'] . ' </span> </td>
                <td> <span > ' . substr($row['DESCRIPCION_CORTA'], 0, 41) . '... </span></td>
                <td>' . $sFeatured . ' </td>
                <td> <img src="' . $row['URL_IMAGEN'] . '" width="60" height="60"> </td>
            </tr>';
    }
    ?>
</table>
<?php
include('sec/inc.footer.php');
?>
