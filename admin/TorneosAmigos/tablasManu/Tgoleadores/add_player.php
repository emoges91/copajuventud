<?php
 include('../../conexiones/conec_cookies.php');
 
 $sql_consulta="SELECT * FROM T_GOL_AMI WHERE ID_TORNEO=".$_GET['ID']."";
 $query=mysql_query($sql_consulta,$conn);
 $total_records=mysql_num_rows($query);
?>
<?php
 if($total_records>=10)
 {
	 echo "<script type=\"text/javascript\">alert('Maximo de goleadores completado');history.go(-1);</script>";
 }
?>
<link href="css/add_player.css" type="text/css" rel="stylesheet" />
<body>
<div id="formulario">
	<form method="post" action="save_player.php">
    
      <div id="bloque1">
   		  Nombre:  <input type="text" name="nombre" />
      </div>
      
      1er Apellido: <input type="text" name="apellido1" />
      
      <div id="bloque2">  
        2do Apellido:<input type="text" name="apellido2" />
        Equipo:<input type="text" name="equipo"/>
        <input type="hidden" name="id_torneo" value="<?php echo $_GET['ID']?>"  />
        <input type="hidden" name="NOMB" value="<?php echo $_GET['NOMB']?>"  />
       </div> 
       
       <div id="botones">
       	<input type="submit" value="Guardar" />
        <input type="button" value="Cancelar" onClick="document.location.href='tabla_goleadores.php?ID=<?php echo $_GET['ID']?>&NOMB=<?php echo $_GET['NOMB'];?>';" />
       </div>
       
	</form>
    
</div>
</body>