<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
    .contenedor {
        min-height:45px;
        min-width:150px;
        height:auto !important;
        height:45px;
    }
    </style>
    <script src="js/crearLlaves2_0.js" type="text/javascript"></script>
    <script src="lib/prototype.js" type="text/javascript"></script>
    <script src="src/scriptaculous.js" type="text/javascript"></script>
</head>
<body onLoad="crear_drag();">
	<?php 
    include('../conexiones/conec_cookies.php');
    
    function dividirCadena($cadena){
        $Equipos=explode(",",$cadena);	
        return($Equipos);
    }?>					
	<form name="formulario" action="guardar/guardar_llaves.php" enctype="multipart/form-data" method="post" onSubmit="return validarguardar();">
		<input name="HidNomb"  type="hidden" value="<?php echo $_POST['BNomb']; ?>" />
        <input name="HidEquipos" type="hidden" value="<?php echo $_POST['HidListEqui']; ?>" />
       	<table width="100%">
        	<tr bgcolor="#CCCCCC">
                <td colspan="2" align="center">Crear Llaves</td>
                <td align="right">
                    <input type="submit" value="Guardar">
                    <input type="button" value="Atras" onclick="document.location.href='crear_torneo.php';"/>
                </td>
        	</tr>
            <tr>
                <td width="130px">Nombre del torneo:</td>
                <td><?php echo $_POST['BNomb']; ?></td>
        	</tr>
			<tr>
				<td>Cantidad Partidos Primera Fase: </td>
				<td>
                	<input size="1" maxlength="2" type="text" name="txt_cant_fase" id="txt_cant_fase">
                	<input type="button" onClick="principal();" value="Crear Fases">
               	</td>
			</tr>
            <tr>
            	<td></td>
            	<td id="tdfasesCant"></td>
            </tr>
		</table>
		
        <table>
			<tr>
				<td>
			       <div style="width:200px;background:#CCC;" id="lista" class="lista">
                    <br id="apartir">                   
					 <?php   
					$divEquipos=dividirCadena($_POST['HidListEqui']);
					for ($i=0;$i<count($divEquipos);$i++){
						echo '
						<div style="background:#FF9;position:relative;border-bottom:1px solid #ddd;" id="e_'.$i.'" >*'.$divEquipos[$i].'</div>';
					}
					?>
  					</div>
				<td>
                <td style="width:40px;">
                </td>
                <td >
                	<table id="partidos">
                        <tr id="idtr">
                            
                        </tr>
                    </table>
                </td>
			</tr>
		</table>
		
	</form>
	<script type="text/javascript">
    var arra_items=new Array();
    var arra_nom=new Array();
    <?php
    $i=0;
    for ($i=0;$i<count($divEquipos);$i++){
        echo 'arra_items['.$i.']='.$i.';
        arra_nom['.$i.']="*'.$divEquipos[$i].'";';
    }
    ?>
    
    function rellenar(){
    var i;
    var lista=(document.getElementById('lista'));
        for(i=0;i<arra_items.length;i++){	
            var cadena='e_'+arra_items[i];
            var contenedores=document.getElementById(cadena);
            contenedores.parentNode.removeChild(contenedores);
		
            var texto = document.createTextNode(arra_nom[i]);
            var elemento = document.createElement("div");
            elemento.id = "e_"+arra_items[i];
            elemento.style.background ="#FF9";
			elemento.style.position="relative";
			elemento.style.borderBottom="1px solid #ddd";
            elemento.appendChild(texto);
            lista.appendChild(elemento);            
        }
    }
    
    function crear_drag(){
		var este =new Array();
		if(cant_fases>0){
			este[0]="lista";
			if(array_txt_fases.length>0){
				for(i=1;i<=(array_txt_fases.length+1);i++){
					este[i]="idpartido_"+i+"_"+1;
				}
			}
			else{
				este[1]="lista";
			}
		
			for(var i=0;i<=(array_txt_fases.length+1);i++){
				Sortable.create(este[i],{
				tag:'div',
				dropOnEmpty:true, 
				containment:este,
				constraint:false});
			}
		}
    }
    </script>
</body>
</html>