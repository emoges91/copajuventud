<link type="text/css" rel="stylesheet" href="TorneosAmigos/css/menu_amigos.css" />
<!-- Save for Web Slices (otro2.psd) -->
<table id="Tabla_01" width="1062" height="444" border="0" cellpadding="0" cellspacing="0"  style="margin: auto;" align="center">
	<tr>
    	<td colspan="3" id="banner" style="background:url(img/img_ami/amigos32.png) #000 no-repeat; width:1062px; height:284px;" valign="top">
 			<!-- inicio codigo-->
			<div id="divContenido">
                <table>
                <tr>
                    <td valign="top">
                        <div id="menu_amigos" align="left">
                            <ul>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasAuto/tabla_general.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/general.png" />Tabla General
                                    </a>
                                </li>
                               <!-- <li><img src="img/see_torneo.png" />Mostrar Torneo</li>-->
                                <li>
                                     <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasAuto/tabla_grupos.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/grupos.png" />Tabla Grupos
                                     </a>     	
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/jornadas/jor_grupos.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/jor_grupos.png" />Jornada Grupos
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/jornadas/jor_llaves.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/jor_llaves.png" />Jornada Llaves
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/jornadas/jor_resultados.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/anterior.png" />Resultados
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/jornadas/jor_proxima.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/siguiente.png" />Proxima Fecha
                                    </a>
                                </li>
                                <li>
                                     <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasManu/jug_san/jug_san.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/Referee cards.png" width="30px" height="30px" />Sancionados
                                     </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasManu/Tgoleadores/tabla_goleadores.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/goleo.gif" />Goleadores
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasManu/CtrlDisciplinario/ctrl_disc.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/disciplinario.png" />Control Disciplinario
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasAuto/tabla_menos_batido.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/menos_batido.png" />Arco menos batido
                                    </a>
                                </li>
                                <li>
                                    <a <?php echo 'href="index.php?pag=TorneosAmigos/tablasManu/otros_doc/otros_doc.php&ID_TORAMI='.$_GET['ID_TORAMI'].'"';?>>
                                        <img src="TorneosAmigos/img/otros_doc.png" />Otros Documentos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td valign="top">
                        <?php
                        include_once('admin/TorneosAmigos/conexiones/conec.php');
                        include_once('admin/TorneosAmigos/FPHP/funciones.php');
                        
                        $cadena = "SELECT * FROM t_torneo WHERE ID=".$_GET['ID_TORAMI'];
                        $consulta_torneo= mysql_query($cadena, $conn);
                        $fila=mysql_fetch_assoc($consulta_torneo);
                        
                        
                        //consulta eventos fase de llave
                        $sql_llave = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID_TORAMI']." and TIPO=2";
                        $query_llave = mysql_query($sql_llave, $conn);
                        $row_llave=mysql_fetch_assoc($query_llave);
                        
                        //consulta eventos fase de grupos
                        $sql_grupo = "SELECT * FROM t_eventos WHERE ID_TORNEO=".$_GET['ID_TORAMI']." and TIPO=1";
                        $query_grupo = mysql_query($sql_grupo, $conn);
                        $cant_grupos = mysql_num_rows($query_grupo);//cantidad de enventos en grupos
                        $row_grupo=mysql_fetch_assoc($query_grupo);
                        
                        if($cant_grupos>0){
                            //consulta para obtener la ultima jornada
                            $sql_ultima_grupos="SELECT  MAX(t_jornadas.NUM_JOR) as UJORGRU, MAX(t_jornadas.NUM_JOR)as UGRUGRU  
                                                        FROM t_jornadas
                                                    WHERE t_jornadas.ID_EVE=".$row_grupo['ID'];
                            $consulta_ultima_grupos = mysql_query($sql_ultima_grupos, $conn);
                            $row_ultima_grupos=mysql_fetch_assoc($consulta_ultima_grupos);
                        }
                        else{
                            $row_ultima_grupos['UJORGRU']=0;
                            $row_ultima_grupos['UGRUGRU']=0;
                        }
                        
                        //consulta para optener el ultimo grupo llaves
                        $sql_ultimo_llaves="SELECT  MAX(t_jornadas.GRUPO) as UGRULLA,MAX(t_jornadas.NUM_JOR) as  UJORLLA
                                                    FROM t_jornadas
                                                WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
                        $consulta_ultimo_llaves = mysql_query($sql_ultimo_llaves, $conn);
                        $resultado_ultimo_llaves=mysql_fetch_assoc($consulta_ultimo_llaves);
                        
                        // obtener las jornadas de llaves
                        $sql_total_partidos="SELECT * FROM t_jornadas
                                        WHERE t_jornadas.ID_EVE=".$row_llave['ID'];
                        $consulta_total_partidos = mysql_query($sql_total_partidos, $conn);
                        $cant_partidos = mysql_num_rows($consulta_total_partidos);
                        
                        if(($cant_partidos>0)&&($fila['INSTANCIA'])>1){
                        ?>
                        
                        <?php
						$sql_torneo="SELECT NOMBRE FROM t_torneo WHERE ID=".$_GET['ID_TORAMI'];
						$query_torneo = mysql_query($sql_torneo, $conn);
						$fila_torneo=mysql_fetch_assoc($query_torneo)
						?>
                    	
                    	<p align="center">Torneo: <?php echo $fila_torneo['NOMBRE'];?></p>
                        <table cellpadding="0" cellspacing="0" id="tablaAmi">
                        	<thead>
                            	<th colspan="10" >Fase Llaves</th>	
                           	</thead>
                        <?php
                            $jornada=$row_ultima_grupos['UJORGRU'];
                            $indicador_final=0;
                            while($jornada<$resultado_ultimo_llaves['UJORLLA']){
                                $sql_partidos="SELECT * FROM t_jornadas
                                        WHERE t_jornadas.ID_EVE=".$row_llave['ID']." AND t_jornadas.NUM_JOR=".($jornada+1).
                                        ' ORDER BY t_jornadas.GRUPO ASC ';
                                $consulta_partidos = mysql_query($sql_partidos, $conn);
                                $cant_partidos_fase = mysql_num_rows($consulta_partidos);
                                
                                //etiqueta para mostrar si es final o semifinal
                                $etiqueta='';
                                if($cant_partidos_fase>2){
                                    $etiqueta='Fase de '.$cant_partidos_fase.'avos de Final';
                                }
                                else if($cant_partidos_fase==2){
                                    if($indicador_final<2){
                                        $indicador_final++;
                                        $etiqueta='Semifinales';
                                    }
                                    else{
                                        $etiqueta='Final y Tercer Lugar';
                                    }
                                }
                                else{
                                    $etiqueta='Final';
                                }
                                ?>	
                                	
                                    <tr>
                                        <td colspan="11" align="center">&ensp;</td>
                                    </tr>
                                    <thead>
                                        <th colspan="11"><?php echo $etiqueta;?></th>
                                    </thead>
                                    <thead>
                                        <th colspan="10" align="center">Jornada <?php echo ($jornada+1);?></th>
                                    </thead>
                                    <thead>
                                        <th>Equipo Casa</th>
                                        <th>Marcador</th>
                                        <th></th>
                                        <th>Equipo visita</th>
                                        <th>Marcador</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Jornada</th>
                                        <th>Grupo</th>
                                    </thead>
                                <?php	
                                while($fila_equipos=mysql_fetch_assoc($consulta_partidos)){
                                    //-------------------mostrar cuanto el equipo esta libre---------
                                    if($fila_equipos['ID_EQUI_CAS']<>0){
                                        $str_query_equi_casa="SELECT * FROM T_EQUIPO
                                            WHERE T_EQUIPO.ID=".$fila_equipos['ID_EQUI_CAS'];
                                        $consulta_equi_casa = mysql_query($str_query_equi_casa, $conn);
                                        $fila_equipo_casa=mysql_fetch_assoc($consulta_equi_casa);
                                    }
                                    else{
                                        $fila_equipo_casa['NOMBRE']='LIBRE';
                                    }
                                        
                                    //-------------------mostrar cuanto el equipo esta libre---------
                                    if($fila_equipos['ID_EQUI_VIS']<>0){
                                        $str_query_equi_visita="SELECT * FROM T_EQUIPO
                                            WHERE T_EQUIPO.ID=".$fila_equipos['ID_EQUI_VIS'];
                                        $consulta_equi_visita = mysql_query($str_query_equi_visita, $conn);
                                        $fila_equipo_visita=mysql_fetch_assoc($consulta_equi_visita);
                                    }
                                    else{
                                        $fila_equipo_visita['NOMBRE']='LIBRE';
                                    }	
                                    
                                    //mostrar los marcadores casa con guion encasa de no haberlos jugado
                                    if($fila_equipos['MARCADOR_CASA']==''){
                                        $marcador_casa='-';
                                    }
                                    else{
                                        $marcador_casa=$fila_equipos['MARCADOR_CASA'];
                                    }
                                    
                                    //mostrar los marcadores visita con guion encasa de no haberlos jugado	
                                    if($fila_equipos['MARCADOR_VISITA']==''){
                                        $marcador_visita='-';
                                    }
                                    else{
                                        $marcador_visita=$fila_equipos['MARCADOR_VISITA'];
                                    }
                            
                                    $estado_partido='';
                                    switch($fila_equipos['ESTADO']){
                                            case 0:$estado_partido='No jugado';
                                            break;
                                            case 1:$estado_partido='Pendiente';
                                            break;
                                            case 2:$estado_partido='Siguiente';
                                            break;
                                            case 3:$estado_partido='Jugado';
                                            break;
                                            case 4:$estado_partido='Anterior';
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $fila_equipo_casa['NOMBRE'];?></td>
                                        <td align="center"><?php echo $marcador_casa;?></td>
                                        <td align="center">Vrs</td>
                                        <td align="center"><?php echo $fila_equipo_visita['NOMBRE'];?></td>
                                        <td align="center"><?php echo $marcador_visita;?></td>
                                        <td align="center"><?php echo cambiaf_a_normal($fila_equipos['FECHA']);?></td>
                                        <td align="center"><?php echo $estado_partido;?></td>
                                        <td align="center"><?php echo $fila_equipos['NUM_JOR'];?></td>
                                        <td align="center"><?php echo $fila_equipos['GRUPO'];?></td>
                                    </tr>
                                <?php
                                }
                                $jornada=($jornada+1);
                            }
                            ?>
                            <tfoot>
                                <td colspan="9">&nbsp;</td>
                            </tfoot>
                        </table>
                        <?php
                        }
                        else{
                            echo'<p style="color:#fff; font-size:12px;">Por definir.</p>';
                            ?>
                            
                        <?php
                        }
                        ?>
                  	</td>
                </tr>
                </table>
            </div>
			<!--fin de codigo-->

		</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ami/amigos52.png) no-repeat; width:1062px; height:26px;">
			</td>
	</tr>
    <tr>
		<td colspan="3" style="background:url(img/img_ami/amigos6.png) no-repeat; width:1062px; height:43px;">
			</td>
	</tr>
	<tr>
		<td style="background:url(img/img_ini/inicio_20.png) repeat-y; width:14px; height:66px;">
			</td>
		<td style="background:url(img/img_ini/inicio_21.png) repeat-y; width:1035px; height:66px;">  
			<?php include('content_secundario.html');?>
			</td>
		<td style="background:url(img/img_ini/inicio_22.png) repeat-y; width:13px; height:66px;">
			</td>
	</tr>
	<tr>
		<td colspan="3" style="background:url(img/img_ini/inicio_23.png) no-repeat; width:1062px; height:18px;">
			</td>
	</tr>
</table>