<?php

include('conexiones/conec.php');

$sql = "SELECT * FROM t_login WHERE usu LIKE '" . $_POST['usu'] . "' AND pass LIKE '" . $_POST['pass'] . "'";
$query = mysql_query($sql, $conn);
$cant = mysql_num_rows($query);

if ($cant == 0) {
    echo "<script type=\"text/javascript\">
	alert('El nombre de usuario no pertenece a ninguno de nuestros registros');
	history.go(-1);
	</script>";
} else {
    while ($row = mysql_fetch_assoc($query)) {
        if ($_POST['pass'] == $row['PASS']) {
            session_start();
            setcookie("cdljcrcokies", "" . $_POST['usu'] . "", time() + 300000000);
            header('location: index.php');
        } else {
            echo "<script type=\"text/javascript\">
				alert('La contrasena y el usuario no corresponden');
				history.go(-1);
				</script>";
        }
    }
}
?>