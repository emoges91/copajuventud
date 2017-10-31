<?php
 include('admin/conexiones/conec.php');
?>

<?php
        $sql3 = "SELECT * FROM t_patrocinador WHERE OFICIAL=1";
		$answer = mysql_query($sql3, $conn);
		$row3=mysql_num_rows($answer);

echo'

	<div>
		<marquee direction="left" scrollamount="2" onMouseOver="stop()" onMouseOut="start()">
			';
				while ($row=mysql_fetch_assoc($answer)){
					echo'
					<div>
						<a href="http://'.$row['DIRECCION'].'" target="_blank">
						<img src="admin/patrocinadores/'.$row['URL'].'"  height="66px" style="border:none;">
						</a>
                                                </div>
					';
				}
				echo'
                                    </marquee>
	</div>
';

?>