<?php

if (isset($_GET['tor_ver_id'])) {
    $sTorVerID = $_GET['tor_ver_id'];
} elseif (isset($_SESSION['ID_TORNEO'])) {
    $sTorVerID = $_SESSION['ID_TORNEO'];
} else {
    $sTorVerID = '';
}


?>