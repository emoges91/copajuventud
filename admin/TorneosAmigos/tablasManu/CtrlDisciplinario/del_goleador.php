<?php
 include('../../conexiones/conec_cookies.php');
 $sql="DELETE FROM T_CON_DIS_AMI WHERE ID=".$_GET['id']."";
 $query=mysql_query($sql,$conn);
 header('location: ctrl_disc.php?ID='.$_GET['id_torneo'].'&NOMB='.$_GET['NOMB']);
?>