<?PHP
include ('conexiones/conec_cookies.php');


$nPage = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
$nTipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '1';

$nCant = 10;
$nStart = $nPage * $nCant;

$sSql = "SELECT * FROM t_documentos WHERE TIPO=" . $nTipo . " ORDER BY ID LIMIT $nStart,$nCant";
$oQuery = mysql_query($sSql); //habia error porq puso variable $bd y era $base_de_datos

$sSql = "SELECT * FROM t_documentos WHERE TIPO=" . $nTipo . " ORDER BY ID";
$contarok = mysql_query($sSql); //mismo error q en la linea 29
$nTotalDoc = mysql_num_rows($contarok);
$nPages = intval($nTotalDoc / $nCant);


$sTitulo = '';
switch ($nTipo) {
    case '1':
        $sTitulo = 'Reglamentos';
        break;
    case '2':
        $sTitulo = 'Comite Disciplinario';
        break;
    case '3':
        $sTitulo = 'Comite Competencia';
        break;
    case '4':
        $sTitulo = 'Otros Documentos';
        break;
    case '6':
        $sTitulo = 'Informes Arbitrales';
        break;
    case '7':
        $sTitulo = 'Revision Arbitral';
        break;
    case '5':
        $sTitulo = 'Costo de Arbitraje';
        break;
}

include('sec/inc.head.php'); 
?>

<h2>Repositorio de <?php echo $sTitulo; ?> </h2>
<hr>
<br/>
<div width="100%" class="right">
    <input class="buton_css" type="button" onclick="document.location.href = 'doc_add.php?tipo=<?php echo $nTipo; ?>';" value="Agregar"/> 
</div>
<div class="clear"></div>
<br/>

<table class="table_content" width="100%">
    <tr>
        <td><b>Acciones</b></td>
        <td><b>Asunto del archivo</b></td>
        <td><b>Fecha de publicacion</b> </td>
    </tr>
    <?php
    while ($aDoc = mysql_fetch_assoc($oQuery)) {
        $sLinkDelete = 'doc_delete.php?id=' . $aDoc['ID'] . '&asunto=' . $aDoc['ASUNTO'] . '&tipo=' . $aDoc['TIPO'];
        echo '
            <tr>
                <td>
                    <a href="' . $sLinkDelete . '" onclick="javascript: return sure();">Eliminar</a>
                    ||
                    <a href="' . $aDoc['URL_DOCUMENTO'] . '" target="_blank">Descargar</a>
                </td>
                <td>
                        ' . $aDoc['ASUNTO'] . '
                </td>
                <td>
                        ' . $aDoc['FECHA'] . '
                </td>
            </tr>';
    }
    ?>
</table>
<?php
echo '<h2>';
if ($nPage != 0) {
    $url = $nPage - 1;
    echo '<a href="doc.php?pg=' . $url . '" class="hiper">&laquo; Anterior</a>&nbsp;';
}
for ($i = 0; $i <= $nPages; $i++) {
    if ($i == $nPage) {
        if ($i == "0") {
            echo "<b> 1 </b>";
        } else {
            $j = $i + 1;
            echo "<b> " . $j . " </b>";
        }
    } else {
        if ($i == "0") {
            echo '<a href="doc.php?pg=' . $i . '" class="hiper">1</a>  ';
        } else {
            echo '<a href="doc.php?pg=' . $i . '" class="hiper">';
            $j = $i + 1;
            echo $j . "</a> ";
        }
    }
}
if ($nPage < $nPages) {
    $url = $nPage + 1;
    echo '<a href="doc.php?pg=' . $url . '" class="hiper">Siguiente &raquo; </a>';
}
echo "</h2>";

include('sec/inc.footer.php');
?>
