<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Editar Torneo</title>
        <link rel="stylesheet" href="../css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
        <script src="../js/funciones.js" type="text/javascript"></script>
    </head>
<body>
	<?php
    include('../conexiones/conec_cookies.php');
	
	$sql = "SELECT * FROM t_torneo WHERE ID = '".$_GET['ID']."'";
	$query = mysql_query($sql, $conn);
	$row=mysql_fetch_assoc($query)

	?>
    <form name="formulario" action="editar/guardar_editar_torneo.php" enctype="multipart/form-data" method="post">
    <table width="100%" style="margin-bottom:40px;">
    <tr align="center" bgcolor="#CCCCCC" >
    	<td colspan="2">Editar Torneo</td>
        <td align="right">       
        	<input type="button" value="Cancelar" onClick="document.location.href='../index.php';"/>
        </td>
    </tr>
    <tr class="filas">
    	<td width="130px">Nombre del torneo</td>
    	<td>
        	<input name="NOMBRE" type="text" value= "<?php echo $row['NOMBRE'];?>" maxlength="50" size="50px"/>
        	<input type="hidden" name="ID" value="<?php echo $row['ID']?>">
            <input type="submit" value="Guardar"/>
        </td>
    </tr>
    </table>
    </form>
    
    <table class="tablasSeguidas" width="100%">
        <tr>
    		<td align="center" width="150px">
            <form name="formulario_gru" action="editar/borrar_grupos.php?ID=<?php echo $_GET['ID'];?>" enctype="multipart/form-data" method="post" onSubmit="return sure();">
        		<input type="submit" value="Borrar Fase Grupos" />
            </form>
            </td>
    		<td align="left">
            <form name="formulario_llav" action="editar/borrar_llaves.php?ID=<?php echo $_GET['ID'];?>" enctype="multipart/form-data" method="post" onSubmit="return sure();">    
        		<input type="submit" value="Borrar Fase llaves"/>
            </form>
            </td>
        </tr>
        <tr >
        	<td></td>
        	<td>Jornadas Llaves</td>
        </tr>
        <tr>
        	<td></td>
        	<td valign="top" >
            <?php
				//consulta eventos fase de llave de la tabla eventos
				$sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$row['ID']." and TIPO=2";
				$query_llave = mysql_query($sql_llave, $conn);
				$row_llave=mysql_fetch_assoc($query_llave);
				
				//seleccionar la ultima jornada
				$sql_max_jornada="SELECT MAX(t_jornadas.NUM_JOR) AS MAX_JOR FROM t_jornadas
					WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
				$consulta_max_jornada = mysql_query($sql_max_jornada, $conn);
				
				//seleccionar la primera jornada
				$sql_min_jornada="SELECT MIN(t_jornadas.NUM_JOR) AS MIN_JOR FROM t_jornadas
					WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
				$consulta_min_jornada = mysql_query($sql_min_jornada, $conn);
				
				//seleccionar la jornada actual
				$sql_act_jornada="SELECT MIN(t_jornadas.NUM_JOR) AS ACT_JOR FROM t_jornadas
					WHERE t_jornadas.ID_EVE=".$row_llave['ID']. " AND t_jornadas.ESTADO=2";
				$consulta_act_jornada = mysql_query($sql_act_jornada, $conn);
            	
				$row_max_jornada=mysql_fetch_assoc($consulta_max_jornada);
				$row_min_jornada=mysql_fetch_assoc($consulta_min_jornada);
				$row_act_jornada=mysql_fetch_assoc($consulta_act_jornada);
					
				/// condicio de que si hay primera y ultimajornada
				if(($row_min_jornada['MIN_JOR']!="")&&($row_max_jornada['MAX_JOR']!="")){
			?>
					<form action="editar/retroceder_llaves.php" method="post" onSubmit="return sure();">
					<table>
					<input type="hidden" name="id_tor" value="<?php echo $_GET['ID'];?>"> <!--guardar el id torneo-->
					<input type="hidden" name="id_eve" value="<?php echo $row_llave['ID']; ?>"> <!--guardar el id evento-->
					<input type="hidden" name="min_max" value="<?php echo $row_min_jornada['MIN_JOR'].'/'.$row_max_jornada['MAX_JOR'];?>"> <!--guardar el la ultima jornada y la primera-->
					
					<?php
                    //recorre las jornadas apartir de la primera de face de llaves y hasta la ultima
					for($i=$row_min_jornada['MIN_JOR'];$i<=$row_max_jornada['MAX_JOR'];$i+=2){
						
						if(($row_act_jornada['ACT_JOR']==$i)||($row_act_jornada['ACT_JOR']==($i+1))){
							$chekear="checked";
						}
						else{
							$chekear="";
						}
						
						if($i==$row_max_jornada['MAX_JOR']){
						?>
							<tr>
								<td><input type="radio" name="radio_llaves"  <?php echo $chekear;?> value="<?php echo $i;?>/0"></td>
								<td>Final Y 3º Lugar Jornada  <?php echo$i;?></td>
							</tr>
                        <?php
						}
						else if($i==($row_max_jornada['MAX_JOR']-2)){
						?>
							<tr>
								<td><input type="radio" name="radio_llaves" <?php echo $chekear;?> value="<?php echo $i.'/'.($i+1);?>"></td>
								<td>Semifinales Jornadas <?php echo $i.' - '.($i+1);?></td>
							</tr>
                        <?Php
						}
						else{
						?>
							<tr>
								<td><input type="radio" name="radio_llaves" <?php echo $chekear;?> value="<?php echo $i.'/'.($i+1);?>"></td>
								<td>Jornadas <?php echo$i.' - '.($i+1);?></td>
							</tr>
                    <?Php
						}
					}
					?>
						<tr>
							<td colspan="2"><input type="submit" value="Retroceder"></td>
						</tr>
					</table>
					</form>
				<?php
				}
				else{
					echo 'La fase de llaves no ha sido creada.';
				}
				?>	
            </td>            
        </tr>
    </table>
 
</body>
</html>