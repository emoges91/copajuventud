<?php

include ('conexiones/conec_cookies.php');

$sNombre = (isset($_POST['nombre']) ? $_POST['nombre'] : '');
$sDesc = (isset($_POST['desc']) ? $_POST['desc'] : '');

if ($sNombre != '' && $sDesc != '') {
    $dFecha = date("Y-m-d");
    $dir = date("YnjHis");

    $ccdo = @mkdir("imgen/original/" . $dir, 0777, true);
    $ccdt = @mkdir("imgen/thumbs/" . $dir, 0777, true);
    $ccdt3 = @mkdir("imgen/thumbs300/" . $dir, 0777, true);

    if ($ccdo && $ccdt && $ccdt3) {

        $sql = "
            INSERT INTO t_albun 
            VALUES 
                (null,'" . $sNombre . "','" . $sDesc . "','" . $dFecha . "','" . $dFecha . "','" . $dir . "',0,0)";
        $query = mysql_query($sql);
        $nLastID = mysql_insert_id();

        echo "
            <script type=\"text/javascript\">
                alert('El albun fue registrado');
                document.location.href='foto_add.php?ID=" . $nLastID . "';
            </script>";
    } else {
        echo "
            <script type=\"text/javascript\">
                alert('Ocurrio un error durante la creacion del albun. Vuelva a intentar.');
                history.go(-1);
            </script>";
    }
} else {
    echo "
        <script type=\"text/javascript\">
            alert('Se debe digitar un nombre y descripcion del albun');
            history.go(-1);
	</script>";
}
?>
