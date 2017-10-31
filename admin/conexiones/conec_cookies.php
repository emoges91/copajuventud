<?php
if (@!isset($_COOKIE['cdljcrcokies']) and @$_COOKIE['cdljcrcokies'] == '') {
    echo '<center><br>Debe estar identificado como usuario para poder ingresar<br>
	<a href="login.php">click aqui para iniciar sesion</a></center>';
    exit();
}


//$servidor='coparotativapz.globatmysql.com';
//$usuario='copa_cj';
//$pass='COPAROTATIVA2010';
//$base_de_datos='bdcj';

$servidor = 'localhost';
$usuario = 'casa2014_app';
$pass = 'mqqZ8Io0t(sb';
$base_de_datos = 'casa2014_bd';


if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $servidor = 'localhost';
    $usuario = 'root';
    $pass = '';
    $bd = 'bdcj';
}
@session_start();
$conn = mysql_connect($servidor, $usuario, $pass);
mysql_select_db($base_de_datos);
mysql_set_charset('utf8');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
mysql_query('set names utf8'); 
?>