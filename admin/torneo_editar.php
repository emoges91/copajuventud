<?php
include('conexiones/conec_cookies.php');
include('sec/inc.head.php'); 


$nTorneoID = (isset($_GET['id'])) ? $_GET['id'] : 0;

$sql = "SELECT * FROM t_torneo WHERE ID = '" . $nTorneoID . "'";
$query = mysql_query($sql, $conn);

$row = mysql_fetch_assoc($query)
?>
<h1>Editar Torneo</h1>
<hr/>
<br/>

<form name="formulario" action="torneo_editar_guardar.php" enctype="multipart/form-data" method="post">
    <table>
        <tr>
            <td>Nombre del torneo</td>
            <td>
                <input name="NOMBRE" type="text" value= "<?php echo $row['NOMBRE']; ?>" maxlength="50" size="50px"/>
                <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">
            </td>
        </tr>
        <tr>
            <td>Edicion</td>
            <td><input name="EDICION" type="text" value= "<?php echo $row['YEAR']; ?>"/></td>
        </tr>

    </table>
    <br/><br/>
    <div>
        <input type="submit" value="Guardar" class="buton_css">
        <input type="button" value="Atras" onclick="document.location.href = 'torneo.php';" class="buton_css"/>
    </div>
</form>

<br/><br/>

<h2>Resetear Fase Completa</h2>
<div>
    <form name="formulario_gru" action="borrar_grupos.php?id=<?php echo $nTorneoID; ?>" enctype="multipart/form-data" method="post" onSubmit="return sure();"  >
        <input type="submit" value="Borrar grupos" class="buton_css"/>
    </form>
</div>
<br/>
<div>
    <form name="formulario_llav" action="borrar_llaves.php?id=<?php echo $nTorneoID; ?>" enctype="multipart/form-data" method="post" onSubmit="return sure();">    
        <input type="submit" value="Borrar llaves" class="buton_css"/>
    </form> 
</div>

<br/><br/>
<?php

include('sec/inc.footer.php');
?>