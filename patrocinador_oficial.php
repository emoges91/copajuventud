


<?php include('admin/conexiones/conec.php');?>

<?php
        $sql3 = "SELECT * FROM t_patrocinador WHERE OFICIAL=1";
		$RESUL = mysql_query($sql3, $conn);
		$row3=mysql_num_rows($RESUL);

echo'<BODY BGCOLOR="#ff6801">
<div class="moduletable">
<marquee direction="up" scrollamount="2" onMouseOver="stop()" onMouseOut="start()">

<table border="0" width="170px" class="moduletable" cellspacing="0" cellpadding="25" align="center">



<table border="0"  width="170px">';
while ($row=mysql_fetch_assoc($RESUL))
{
echo'
<tr><td valign="top" style="text-align: center"><a href="http://'.$row['DIRECCION'].'" target="_blank"><img src="admin/patrocinadores/'.$row['URL'].'" width="145px",
height="90px" align="left" style="border:none;"></td></tr>
';
}
echo'
</table></table>';

?>