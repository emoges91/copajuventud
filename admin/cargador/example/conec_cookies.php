<?php 

if (@!isset($_COOKIE['cdljcrcokies']) and @$_COOKIE['cdljcrcokies'] == ''){
	echo '<center><br>Debe estar identificado como usuario para poder ingresar<br>
	<a href="login.php">click aqui para iniciar sesion</a></center>';
	exit();
}


$servidor='localhost';
$usuario='root';
$pass='';
$bd='BD_CJ';

$conn = mysql_connect($servidor, $usuario, $pass);
mysql_select_db($bd);

?>