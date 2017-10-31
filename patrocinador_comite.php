<?php
 include('admin/conexiones/conec.php');
?>

<?php
        $sql3 = "SELECT * FROM t_patrocinador WHERE OFICIAL=1";
		$answer = mysql_query($sql3, $conn);
		$row3=mysql_num_rows($answer);

echo'
<BODY BGCOLOR="#ff6600">
	<div >
		<marquee direction="left" scrollamount="2" onMouseOver="stop()" onMouseOut="start()">
			<table border="0" cellspacing="0" cellpadding="0" width="170px">
				<tr>';
				while ($row=mysql_fetch_assoc($answer)){
					echo'
					<td valign="top">
						<a href="http://'.$row['DIRECCION'].'" target="_blank">
							<img src="admin/patrocinadores/'.$row['URL'].'" height="66px" style="border:none;">
						</a>
					</td>
					<td>
					&nbsp;
					</td>';
				}
				echo'
				</tr>
			</table>
	</div>
</body>';

?>