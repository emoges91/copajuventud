
<?php
include('conexiones/conec_cookies.php');

$pg = (isset($_GET['pg'])) ? $_GET['pg'] : 0;

$total = 2;
$cantidad = 8; 
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_albun ORDER BY ID DESC LIMIT $inicial,$cantidad";
$cad = mysql_query($pegar, $conn) or die(mysql_error()); //habia error porq puso variable $bd y era $base_de_datos

$contar = "SELECT * FROM t_albun ORDER BY ID DESC";
$contarok = mysql_query($contar, $conn); //mismo error q en la linea 29
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);

include('sec/inc.head.php');
?>
<h1>Album de Fotos</h1>
<hr>
<br/>
<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'album_add.php';" value="Agregar"/> 
</div>
<div class="clear"></div>
<br/>
<?php
// Imprimiendo los resultados
if ($total_records > 0) {

    while ($row = mysql_fetch_assoc($cad)) {
        $sql2 = "SELECT * FROM t_img WHERE ID='" . $row['PORTADA'] . "'";
        $que2 = mysql_query($sql2, $conn);
        $row2 = mysql_fetch_assoc($que2);

        echo '
            <div class="album_box"> 
                <a href="detalle_album.php?ID=' . $row['ID'] . '" title="' . $row['DESCRIP'] . '">
                    <img src="' . $row2['URL_THUMB300'] . '"  alt="' . $row['NOMBRE'] . '" />
                </a>
                <h3> ' . $row['NOMBRE'] . '</h3>
                <p>' . $row['DESCRIP'] . '</p>
                <h5>' . $row['FEC_CRE'] . '</h5>
                <p>
                    <a href="fotos.php?ID=' . $row['ID'] . '">Fotos</a>  
                    || 
                    <a href="album_edit.php?ID=' . $row['ID'] . '">Editar</a>  
                    ||  
                    <a href="album_delete.php?ID=' . $row['ID'] . '"onclick="javascript: return sure();">Eliminar</a>	
                </p>  
            </div>';
    }
} else {
    echo '<p>No hay ningun album</p>';
}

echo '<h2 class="align_center">';
if ($pg != 0) {
    $url = $pg - 1;
    echo '<a href="fotos.php?pg=' . $url . '">&laquo; Anterior</a>&nbsp;';
} else {
    echo " ";
}
for ($i = 0; $i <= $pages; $i++) {
    if ($i == $pg) {
        if ($i == "0") {
            echo "<b> 1 </b>";
        } else {
            $j = $i + 1;
            echo "<b> " . $j . " </b>";
        }
    } else {
        if ($i == "0") {
            echo '<a href="fotos.php?pg=' . $i . '">1</a> ';
        } else {
            echo '<a href="fotos.php?pg=' . $i . '">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($pg < $pages) {
    $url = $pg + 1;
    echo '<a href="fotos.php?pg=' . $url . '">Siguiente &raquo; </a>';
}
echo "</h2>";
?>
<?php
include('sec/inc.footer.php');
?>