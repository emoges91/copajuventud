<?php

include('conexiones/conec_cookies.php');
$bandera = 0;

$sCED = (isset($_POST['CED'])) ? $_POST['CED'] : '';
$sNOMBRE = (isset($_POST['NOMBRE'])) ? $_POST['NOMBRE'] : '';
$sAPELLIDO1 = (isset($_POST['APELLIDO1'])) ? $_POST['APELLIDO1'] : '';
$sAPELLIDO2 = (isset($_POST['APELLIDO2'])) ? $_POST['APELLIDO2'] : '';
$sDIR = (isset($_POST['DIR'])) ? $_POST['DIR'] : '';
$sACTIVO = (isset($_POST['ACTIVO'])) ? $_POST['ACTIVO'] : '0';

if (($sCED != '') and ( $sNOMBRE != '') and ( $sAPELLIDO1 != '') and ( $sAPELLIDO2 != '')) {
    $sql = "select * from t_personas where CED='" . $sCED . "'";
    $VER = mysql_query($sql, $conn);
    while ($row = mysql_fetch_assoc($VER)) {
        if ($_POST['CED'] == $row['CED']) {
            $bandera = 1;
        }
        if ($_POST['ID'] == $row['ID']) {
            $bandera = 0;
        }
    }
    if ($bandera == 0) {

        $act = 1;
        if ($sACTIVO != '1') {
            $act = 0;
        }
        
        $sql = "UPDATE t_personas 
                SET
                    CED = '" . $_POST['CED'] . "',
                    NOMBRE = '" . $sNOMBRE . "',
                    APELLIDO1 = '" . $sAPELLIDO1 . "',
                    APELLIDO2 = '" . $sAPELLIDO2 . "',
                    DIR = '" . $sDIR . "',
                    TEL = '" . $_POST['TEL'] . "',
                    ACTIVO='" . $act . "'

                    WHERE ID = '" . $_POST['ID'] . "'
                    ";
        $query = mysql_query($sql, $conn);


        echo "<script type=\"text/javascript\">
   					alert('La persona editada');
					document.location.href='personas.php';
			</script>";
    } else {
        echo "<script type=\"text/javascript\">
			alert('Cedula repetida...Por favor verifique!!!');
			history.go(-1);
		</script>";
    }
} else {
    echo "<script type=\"text/javascript\">alert('Los campos con asterisco (*) son requeridos');history.go(-1);</script>";
}
?>