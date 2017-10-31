<?php	
    include('conexiones/conec_cookies.php');
?>
<html>
	<head>
    	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
    	<script src="js/funciones.js" type="text/javascript"></script>
		<title>Torneo Amigos</title>
    </head>
	<body>
    <form name="formulario" action="editorTorneo/crear_torneo.php" enctype="multipart/form-data" method="post">
    <table width="100%">
        <tr bgcolor="#CCCCCC">
            <td>Torneos Amigos</td>
            <td align="right">
                <input type="submit" value="Crear Torneo"/> 
                <input type="button" value="Pagina Principal" onclick="document.location.href='../index.php';"/>
            </td>
        </tr>
    </table>
    </form>
       
   <?php
   $sql= "select * from t_torneo";
   $query= mysql_query($sql,$conn);
   $cant= mysql_num_rows($query);
   $numero=0;
   if($cant>0){
	?>   
        <table border="0" align="center" width="100%" cellpadding="1" cellspacing="0">
        <tr>
        	<td colspan="4" align="center">
            	<h3>Ediciones</h3>
            </td>
        </tr>
	   <tr bgcolor="#000000" class="encabezado" >
	   		<td width="30px"></td>  
			<td width="50px"></td>
            <td width="50px"></td>
	   		<td>Nombre</td>
			<td>Mostrar</td>
       	</tr>
     <?php   
        while ($row=mysql_fetch_assoc($query)){
	 ?>
     		<tr class="filas">
				<td>
					<p align="center"> <?php echo($numero=$numero+1);?></p>
				</td>
				<td align="center">
					<a href="editorTorneo/eliminar/eliminar_torneo.php?ID=<?php echo $row['ID'];?>" onClick="javascript: return sure();">
                    	<img src="img/icono_eliminar.png" title="Eliminar"/></a>
                </td>
                <td align="center">
					<a href="editorTorneo/editar_torneo.php?ID=<?php echo $row['ID'];?>">
                    	<img src="img/icono_editar.png" title="Editar"/></a>
				</td>
				<td >              
                	 <a href="mostrar_torneo.php?ID=<?php echo $row['ID'];?>&NOMB=<?php echo $row['NOMBRE'];?>"> <?php echo $row['NOMBRE'];?></a>
                </td>   
				<td> 
				<?php 
				if($row['ACTUAL']==2){
					echo '
					<a href="editar/activar_torneo.php?ID='.$row['ID'].'&TIPO=1">
						<img src="img/verde.png" title="Mostrar"/>
					</a>';
				}
				else{
					echo '
					<a href="editar/activar_torneo.php?ID='.$row['ID'].'&TIPO=2">
						<img src="img/rojo.png" title="Ocultar"/>
					</a>';
				}?>
                </td>
			</tr>
		<?php }?>
       </table>
	 
   <?php    
   }
   else{
		echo '<center>Lista de torneos vacia</center>';
	}	   
    ?>
	</body>
</html>