<?php
include('../conexiones/conec_cookies.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Crear Torneo</title>
        <script type="text/javascript" src="js/popup-window.js"></script>
        <script type="text/javascript" src="js/agre_equi.js"></script>
        <link rel="stylesheet" type="text/css" href="css/sample.css" />
    </head>

    <body>
        <form name="formulario" action="formularioGrupos.php" enctype="multipart/form-data" method="post" onSubmit="obtenerElementos();" id="formulario">
        <table width="100%">
        <tr bgcolor="#CCCCCC">
            <td colspan="2" align="center" >Crear Torneo</td>
            <td align="right">
            	<input type="submit" value="Siguiente"/>
            	<input type="button" value="Cancelar"onclick="document.location.href='../index.php';"/>
            </td>
        </tr>
        <tr>
            <td width="130px">Nombre del torneo:</td>
            <td><input name="BNomb" type="text" value="" maxlength="50" size="50px"/></td>
            <td></td>
        </tr>
        <tr>
            <td>Iniciar por: </td>
            <td>
                Grupos:<input name="RBGruLlav" type="radio" value="0" checked> <br>
                Llaves: <input name="RBGruLlav" type="radio" value="1">
            </td>
             <td></td>
        </tr>
        </table>
        
        <!-- tabla de equipos    -->
        <table>
        	<tr height="20px">
            	<td></td>
                <td></td>
            </tr>
            <tr align="center">               
                <td><h3>Equipos Disponibles</h3></td>    
                <td>
                	<input name="BAgreEqui" type="button" value="Agregar Equipo" 
                	id="pos_right" onClick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  10, 0, 'pos_right' );">
                </td>      
            </tr>
            <tr>
                <td valign="top">
                    <div style="width:500px;background:#CCC;" id="lista" class="lista">
                    <br id="apartir">                 
                    </div>                            
                </td>
                <td>
                	<input name="HidListEqui" type="hidden" value="" id="HidListEqui">
                </td>                
            </tr>  
        </table>
    </form>
    
    <!-- ***** Popup Window **************************************************** -->
	<div class="sample_popup"     id="popup" style="display: none;">
        <div class="menu_form_header" id="popup_drag">
        	<img class="menu_form_exit"   id="popup_exit" src="img/form_exit.png" alt=""  />
        	<center>Agregar Equipos</center>
        </div>
        <div class="menu_form_body">
            <table>
              <tr>
              	<th>Equipo:</th>
                <td><input class="field" type="text" name="equipo" value="" id="TexNomEqui"  /></td>
              </tr>
              <tr>
              	<th>         </th>
                <td><input class="btn"   type="button"   value="Agregar" onClick="agregarEquipo(document.getElementById('TexNomEqui').value);" /></td>
              </tr>
            </table>
        </div>
	</div>
 <!-- ***** Popup Window **************************************************** -->
 
    </body>
</html>
