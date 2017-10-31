<?php
//$servidor='coparotativapz.globatmysql.com';
//$usuario='cjtoramiuser';
//$pass='CJpzpassami';
//$bd='dbtorami';

$servidor='localhost';
$usuario='casa2014_app';
$pass='mqqZ8Io0t(sb';
$bd='casa2014_bd';



$conn = mysql_connect($servidor,$usuario,$pass);
if (!$conn) { 
    die('Could not connect: ' . mysql_error()); 
} 
mysql_select_db($bd);
?>