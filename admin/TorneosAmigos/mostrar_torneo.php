<?php
include_once($dire.'conexiones/conec_cookies.php');
?>
<link rel="stylesheet" href="<?php echo $dire;?>css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
<table width="100%" border="0" class="menuBackEnd" cellpadding="0" cellspacing="0">
	<tr>
    	<th align="left" width="200px">
        	<a href="<?php echo $dire;?>index.php">Torneos Amigos</a>
        </th>
        <th style="color:#ADBCD1;">Torneo: <?php echo $_GET['NOMB'];?></th>
        <th align="right" style="padding-right:50px;">
        	<a href="<?php echo $dire;?>../cerrar.php">
            	<img class="resplandor" src="<?php echo $dire;?>img/cerrarsesion.gif" title="Cerrar Sesion"/>
           	</a>
        </th>
    </tr>
    <tr>
		<td colspan="3" >
        	<a href="<?php echo $dire;?>tablasAuto/tabla_general.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Tabla General</a>
			||  <a href="<?php echo $dire;?>tablasAuto/tabla_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Tabla Grupos</a>
            ||  <a href="<?php echo $dire;?>tablasAuto/tabla_menos_batido.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>" title="Arco Menos Batido">Tabla Menos Batidos</a>
			||  <a href="<?php echo $dire;?>jornadas/jor_grupos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Jornadas Grupos</a>
			||  <a href="<?php echo $dire;?>jornadas/jor_llaves.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Jornadas Llaves</a>
			||  <a href="<?php echo $dire;?>tablasManu/Tgoleadores/tabla_goleadores.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Tabla Goleadores</a>
            ||  <a href="<?php echo $dire;?>tablasManu/CtrlDisciplinario/ctrl_disc.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Control Disciplinario</a>
            ||  <a href="<?php echo $dire;?>tablasManu/DatosManuales/registrar_documentos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Documentos</a>
            ||  <a href="<?php echo $dire;?>equipos/mostrar_equipos.php?ID=<?php echo $_GET['ID'];?>&NOMB=<?php echo $_GET['NOMB'];?>">Equipos</a>
        </td>
    </tr>
</table>