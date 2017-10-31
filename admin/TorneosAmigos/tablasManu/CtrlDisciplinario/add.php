<?php
 include('../../conexiones/conec_cookies.php');
 $sql="SELECT * FROM T_CON_DIS_AMI WHERE ID_TORNEO=".$_GET['id_torneo'];
 $query=mysql_query($sql,$conn);
 $cant=mysql_num_rows($query);
 
 if($cant>=35)
 {
	echo "<script type=\"text/javascript\">alert('Maximo de equipos ingresado');history.go(-1);</script>";  
 }
?>
<table align="center" style="margin-left:200px; margin-top:100px;">
    <form action="save_add.php" method="post" style="margin-left:200px; margin-top:100px;"">
    <tr>
    Equipo:<input type="text" name="equipo" />
    </tr>
    
    <tr>
    <input type="hidden" value="<?php echo $_GET['id_torneo'] ;?>" name="id_torneo" />
    <input type="hidden" value="<?php echo $_GET['NOMB'] ;?>" name="NOMB" />
    <input type="submit"  value="Guardar"/>
    <input type="button" value="Cancelar" 
    	onClick="document.location.href='ctrl_disc.php?ID=<?php echo $_GET['id_torneo']?>&NOMB=<?php echo $_GET['NOMB'];?>';"/>
    </tr>
    </form>
</table>