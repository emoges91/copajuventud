<script src="../script_piker/picker.js" type="text/javascript" charset="utf-8"></script>	
<link rel="stylesheet" href="../script_piker/piker.css" type="text/css" media="screen" charset="utf-8" /> 
<?php
include('../conexiones/conec_cookies.php');

function buscar_punto($cadena){
 if (strrpos($cadena,"."))     
     return true;     
 else    
     return false;     
}


if(is_numeric($_POST['cant_equi'])&&buscar_punto($_POST['cant_equi'])==false){
echo'<form action="guardar_amigos.php" method="post">
<table align="center">
	<tr>
		<td colspan="9" align="center">
			'.$_POST['nombre'].'
			<input type="hidden" name="nom_torneo" value="'.$_POST['nombre'].'">
			<input type="hidden" name="info" value="'.$_POST['cant_equi'].'/'.$_POST['estado'].'">
			</td>
	</tr>
	<tr>
		<td colspan="9">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="9" align="center">Tabla</td>
	</tr>
	<tr>
		<td colspan="2">Equipo</td>
		<td>PJ</td>
		<td>PG</td>
		<td>PE</td>
		<td>PP</td>
		<td>GA</td>
		<td>GR</td>
		<td>PTS</td>
	</tr>';
	for($i=1;$i<=$_POST['cant_equi'];$i++){
	echo'	
	<tr>
		<td>'.$i.'</td>
		<td><input type="text" name="nom_equi'.$i.'" maxlength="60" size="36px"></td>
		<td><input type="text" name="pj'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="pg'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="pe'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="pp'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="ga'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="gr'.$i.'" maxlength="2" size="2px"></td>
		<td><input type="text" name="pts'.$i.'" maxlength="2" size="2px" ></td>
	</tr>';
	}
echo '
	<tr>
		<td colspan="9">&nbsp;</td>
	</tr>
</table>
';

echo '
<table align="center">
	<tr>
		<td colspan="6" align="center">Jornadas</td>
	</tr>
	<tr>
		<td>Equipos casa</td>
		<td>Marcador</td>
		<td></td>
		<td>Equipo visita</td>
		<td>Marcador</td>
		<td>Fecha</td>
	</tr>
';
$residuo=$_POST['cant_equi']%2;
if($residuo==1){
	$num_jor=1;
}
$num_jor=($num_jor+$_POST['cant_equi'])/2;

for($i=1;$i<=$num_jor;$i++){
	echo'
	<tr>
		<td><input type="text" name="equipo_casa'.$i.'" maxlength="60"></td>
		<td><input type="text" name="marc_casa'.$i.'" maxlength="2" size="6px" ></td>
		<td>Vrs</td>
		<td><input type="text" name="equipo_vis'.$i.'" maxlength="60"></td>
		<td><input type="text" name="marc_vis'.$i.'"  maxlength="2" size="6px"></td>
		<td><input type="text" name="fecha'.$i.'" onclick="displayDatePicker(\'fecha'.$i.'\',this);" maxlength="8" size="8px"></td>
	</tr>
	';
}
echo'	
</table>
<table align="center">
	<tr align="right">
		<td><input type="submit" value="Guardar"></td>
		<td><input type="button" value="Cancelar" onclick="document.location.href=\'torneos_amigos.php\';"></td>
	</tr>
</table>
</form>
';
}
else{
	echo "<script type=\"text/javascript\">
			alert('Se debe digitar nuemeros enteros en la cantidad de equipos');
			history.go(-1);
		</script>";
}
?>