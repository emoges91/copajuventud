<?php
include('../conexiones/conec_cookies.php');

function dividirCadena($cadena){
	$Equipos=explode(",",$cadena);	
	return($Equipos);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Crear Torneo</title>
        <script src="lib/prototype.js" type="text/javascript"></script>
    	<script src="src/scriptaculous.js" type="text/javascript"></script>
         <script src="js/crearGrupos.js" type="text/javascript"></script>
    </head>

    <body onLoad="crear_drag();">
        <form name="formulario" action="guardar/guardar_grupos.php" enctype="multipart/form-data" method="post" onSubmit="obtenerElementos();">
            <input name="HidNomb" type="hidden" value="<?php echo $_POST['BNomb']; ?>" />
            <input name="HidEquipos" type="hidden" value="<?php echo $_POST['HidListEqui']; ?>" />
       	<table width="100%">
        <tr bgcolor="#CCCCCC">
            <td colspan="2" align="center" >Crear Grupos</td>
            <td align="right">
            	<input type="submit" value="Guardar"/>
            	<input type="button" value="Atras"onclick="document.location.href='crear_torneo.php';"/>
            </td>
        </tr>
        <tr>
            <td width="130px">Nombre del torneo:</td>
            <td><?php echo $_POST['BNomb']; ?></td>
        </tr>
        <tr>
            <td>Cantidad de grupos: </td>
            <td>
            <input name="CAN_GRU" type="text" value="0" />
            <input type="button" onClick="crear_lista();" value="Crear grupos">
            </td>
        </tr>
        </table>
    
        <table>
        <tr align="center">
            <td><h3>Equipos disponibles</h3></td>
            <td></td>
        </tr>
        <tr>
            <td valign="top">
                <div style="width:300px;background:#CCC;" id="lista" class="lista">
                    <br id="apartir">       
                    <?php
                     $Divequipos=dividirCadena($_POST['HidListEqui']);
                     for ($i=0;$i<count($Divequipos);$i++){
						 echo '
						 <div style="background:#FF9;position:relative;border-bottom:1px solid #ddd;" id="e_'.$i.'" >*'.$Divequipos[$i].'</div>';
                     }
                     ?>
                 </div>
             </td>
             <td></td>                    
        </tr>  
        </table>
        <table align="center" id="grupos">
        </table>
        </form>
        
		<script type="text/javascript">
        var arra_items=new Array();
        var arra_nom=new Array();
        <?php
		$DivequiposGuardar=dividirCadena($_POST['HidListEqui']);
        for ($x=0;$x<count($DivequiposGuardar);$x++){
            echo '
            arra_items['.$x.']='.$x.';
            arra_nom['.$x.']="*'.$DivequiposGuardar[$x].'";';
        }
        ?>
        
        function rellenar(){	
            var i;
            var lista=document.getElementById('lista');
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
		var i;
		este[0]="lista";
		var otra='';
			if(cantidad_grupos>0){
				for(i=1;i<=cantidad_grupos;i++){
					este[i]="idGrupo"+i;
				}
			}
			else{
				este[1]="lista";
			}
			
			for(i=0;i<=cantidad_grupos;i++){
				Sortable.create(este[i],{
				tag:'div',
				dropOnEmpty:true, 
				containment:este,
				constraint:false});
			}
		}
    </script>
    </body>
</html>
