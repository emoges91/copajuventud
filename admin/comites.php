<?php
include('conexiones/conec_cookies.php');

$sql = "select * from t_comite where TIPO=1";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);

include('sec/inc.head.php');
include('sec/inc.menu_comite.php');
?>

<h1>Comites</h1>
<hr>
<br/>

<h2>Directiva disciplinaria</h2>

<?php
$sql = "select * from t_comite where TIPO=1";
$query = mysql_query($sql);
?> 
<table class="table_content" width="100%">
    <tr>
        <td><b>Acciones</b> </td>
        <td></td>
        <td><b>Nombre</b></td>
        <td><b>Puesto</b> </td>
    </tr>
    <?php
    while ($row = mysql_fetch_assoc($query)) {
        echo '
                <tr>
                    <td>
                        <a href="comite_delete.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '"onclick="javascript: return sure();">
                            Eliminar
                        </a>
                        ||
                        <a href="comite_edit.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '">
                            Editar
                        </a> 
                    </td>
                    <td><img src=" ' . $row['URL_IMAGEN'] . '" width="60" height="50"></td>
                    <td> ' . $row['NOMBRE'] . ' </td>
                    <td> ' . $row['CARGO'] . ' </td>
                </tr>';
    }
    ?>
</table> 
<br/>
<h2>Directiva Competencia</h2>   
<?php
$sql = "select * from t_comite where TIPO=2";
$query = mysql_query($sql);
?> 
<table class="table_content" width="100%">
    <tr>
        <td><b>Acciones</b> </td>
        <td></td>
        <td><b>Nombre</b></td>
        <td><b>Puesto</b> </td>
    </tr>
    <?php
    while ($row = mysql_fetch_assoc($query)) {
        echo '
                <tr>
                    <td>
                        <a href="comite_delete.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '"onclick="javascript: return sure();">
                            Eliminar
                        </a>
                        ||
                        <a href="comite_edit.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '">
                            Editar
                        </a> 
                    </td>
                     <td><img src=" ' . $row['URL_IMAGEN'] . '" width="60" height="50"></td>
                    <td>
                            ' . $row['NOMBRE'] . '
                    </td>
                    <td>
                            ' . $row['CARGO'] . '
                    </td>
                </tr>';
    }
    ?>
</table>
<br/>
<h2>Directiva de Apelacion</h2> 
<?php
$sql = "select * from t_comite where TIPO=3";
$query = mysql_query($sql);
?> 
<table class="table_content" width="100%">
    <tr>
        <td><b>Acciones</b> </td>
        <td></td>
        <td><b>Nombre</b></td>
        <td><b>Puesto</b> </td>
    </tr>
    <?php
    while ($row = mysql_fetch_assoc($query)) {
        echo '
                <tr>
                    <td>
                        <a href="comite_delete.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '"onclick="javascript: return sure();">
                            Eliminar
                        </a>
                        ||
                        <a href="comite_edit.php?id=' . $row['ID'] . '&tipo=' . $row['TIPO'] . '&nombre=' . $row['NOMBRE'] . '">
                            Editar
                        </a> 

                    </td>
                     <td> <img src=" ' . $row['URL_IMAGEN'] . '" width="60" height="50"></td>
                    <td> ' . $row['NOMBRE'] . '</td>
                    <td>' . $row['CARGO'] . '</td>
                </tr>';
    }
    ?>
</table>
<?php
include('sec/inc.footer.php');
?>

