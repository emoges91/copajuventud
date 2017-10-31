<?php 

setcookie("cdljcrcokies", "", time() - 31536000);
header('location: index.php');	
session_destroy();
?>