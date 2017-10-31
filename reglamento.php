<?php
include 'inc.head.php';

$pg = (isset($_GET['pg']) ? $_GET['pg'] : '0');
$sTipo = (isset($_GET['tipo']) ? $_GET['tipo'] : '1');
$cantidad = 6; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$pegar = "SELECT * FROM t_documentos WHERE TIPO=" . $sTipo . " ORDER BY ID LIMIT $inicial,$cantidad";
$cad = mysql_query($pegar) or die(mysql_error()); //habia error porq puso variable $bd y era $base_de_datos
$total_records = mysql_num_rows($cad);
$pages = intval($total_records / $cantidad);

$stittleDoc = 'Documentos de reglamento';
switch ($sTipo) {
    case '2':
        $stittleDoc = 'Documentos de comite disciplinario';
        break;
    case '3':
        $stittleDoc = 'Documentos de comite de competencia';
        break;
     case '4':
        $stittleDoc = 'Otros documentos';
        break;
    case '5':
        $stittleDoc = 'Costo de arbitrajes';
        break;
    case '6':
        $stittleDoc = 'Informes de arbitraje';
        break;
    case '7':
        $stittleDoc = 'Revisi&oacute;n arbitral';
        break;
}
?>
<div class="container ">
    <h1><?php echo $stittleDoc; ?></h1>
    <hr/>
    <?php
    if ($total_records > 0) {

        while ($row = mysql_fetch_assoc($cad)) {
            echo'
            <div class="doc_box">
                <div class="left">
                    <img src="img/file.png" >
                </div>
                <div class="left doc_box_content">
                     <b> ' . $row['ASUNTO'] . '</b>
                    <h5>Fecha: ' . $row['FECHA'] . '</h5>
                    <div class="doc_tools">
                        <a href="descarga.php?file=' . $row['URL_DOCUMENTO'] . '" >
                            <div class="download_icon right"></div>
                        </a> 
                        <a href="admin/' . $row['URL_DOCUMENTO'] . '" target="_blank" onclick="window.open(' . $row['URL_DOCUMENTO'] . ')">      
                            <div class="lupa_icon right"></div>
                        </a>
                        <div class="clear"> </div>
                    </div>
                    
                    <div class="clear"> </div>
                </div>
                <div class="clear"> </div>
            </div>
            ';
        }
    } else {
        echo '<p>No hay datos que mostrar</p>';
    }

// Cerramos la conexión a la base
    $conn = mysql_close($conn);

// Creando los enlaces de paginación
    echo '<div class="paginate">';
    if ($pg != 0) {
        $url = $pg - 1;
        echo '<a href="reglamento.php?pg=' . $url . '" class="hiper">&laquo; Anterior</a>&nbsp;';
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
                echo '<a href="reglamento.php?pg=' . $i . '" class="hiper">1</a> ';
            } else {
                echo '<a href="reglamento.php?pg=' . $i . '" class="hiper">';
                $j = $i + 1;
                echo $j . "</a> ";
            }
        }
    }

    if ($pg < $pages) {
        $url = $pg + 1;
        echo '<a href="reglamento.php?pg=' . $url . '" class="hiper">Siguiente &raquo; </a>';
    }
    echo "</div>";
    ?>
</div>

<?php
include 'inc.footer.php';
?>