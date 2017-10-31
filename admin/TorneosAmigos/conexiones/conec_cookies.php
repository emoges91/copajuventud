<?php 

if (@!isset($_COOKIE['cdljcrcokies']) and @$_COOKIE['cdljcrcokies'] == ''){
	echo '<center><br>Debe estar identificado como usuario para poder ingresar<br>
	<a href="../login.php">click aqui para iniciar sesion</a></center>';
	exit();
}


//$servidor='coparotativapz.globatmysql.com';
//$usuario='cjtoramiuser';
//$pass='CJpzpassami';
//$base_de_datos='dbtorami';

$servidor='localhost';
$usuario='casa2014_app';
$pass='mqqZ8Io0t(sb';
$bd='casa2014_bd';

$conn = mysql_connect($servidor,$usuario,$pass);
mysql_select_db($bd);

?>