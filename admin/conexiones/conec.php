<?php
//$servidor='coparotativapz.globatmysql.com';
//$usuario='copa_cj';
//$pass='COPAROTATIVA2010';
//$bd='bdcj';
$servidor='localhost';
$usuario='casa2014_app';
$pass='mqqZ8Io0t(sb';
$bd='casa2014_bd';

if($_SERVER['SERVER_NAME']=='localhost'){
	$servidor='localhost';
	$usuario='root';
	$pass='';
	$bd='bdcj';
}

$conn = mysql_connect($servidor,$usuario,$pass);
if (!$conn) { 
    die('Could not connect: ' . mysql_error()); 
} 
mysql_select_db($bd);
mysql_set_charset('utf8');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
mysql_query('set names utf8'); 
?>