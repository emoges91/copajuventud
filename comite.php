<?php
include 'inc.head.php';

$sTipo = (isset($_GET['tipo']) ? $_GET['tipo'] : '1');

$contar = "SELECT * FROM t_comite WHERE TIPO=" . $sTipo . " ORDER BY ID";
$contarok = mysql_query($contar); //mismo error q en la linea 29
$total_records = mysql_num_rows($contarok);


$stittleDoc = 'Comite Disciplinario';
switch ($sTipo) {
    case '2':
        $stittleDoc = 'Comite Competencia';
        break;
    case '3':
        $stittleDoc = 'Comite de apelaci&oacute;n';
        break;
}
?>
<div class="container ">
    <h1><?php echo $stittleDoc; ?></h1>
    <hr/>
    <?php
    while ($row = mysql_fetch_assoc($contarok)) {
        echo '
             <div class="comite_box">
                <div class="left">
                    <img src="admin/directiva/' . $row['URL_IMAGEN'] . '" width="80px" height="85px">
                </div>
                <div class="left comite_box_content">
                    <p><b>' . $row['NOMBRE'] . ' ' . $row['APELLIDOS'] . '</b></p>
                    <p>' . $row['CARGO'] . '</p>
                </div>
                <div class="clear"> </div>
             </div>';
 
    }
    ?>
</div>
<?php
include 'inc.footer.php';
?>