<?php
include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/torneos/torneo.php';

$oTorneo = new torneo();
$fila = $oTorneo->getTorneoByID($sTorVerID);

$sSql = "
    SELECT 
    *,
    (e.NOMBRE)AS NOM_EQUI,
    (p.NOMBRE)AS NOM_JUG,
    SUM(GOLEO) as GOL
    FROM t_est_jug_disc ejd
    LEFT JOIN t_personas p ON ejd.ID_JUGADOR = p.ID
    LEFT JOIN t_equipo e ON ejd.ID_EQUIPO = e.ID
    WHERE 
        ejd.ID_TORNEO=" . $fila['ID'] . ' 
    GROUP BY p.ID
    ORDER BY ejd.GOLEO DESC 
    LIMIT 0,15';
$oQuery = mysql_query($sSql, $conn);

include('sec/inc.head.php'); 
include('sec/inc.menu.php');
?>
<h1><?php echo $fila['NOMBRE'] . ' ' . $fila['YEAR'] ?></h1>
<h2>Tabla de Goleadores</h2>
<hr/> 

<table class="table_content">
    <tr>
        <td>Pos.</td>
        <td>Nombre</td>
        <td>Primer Apellido</td>
        <td>Segundo Apellido</td>
        <td>Equipo</td>
        <td>Goles</td>
    </tr>
    <?php
    $nCont = 1;
    while ($aGol = mysql_fetch_assoc($oQuery)) {
        echo'
            <tr>
                <td align="center">' . $nCont . '</td>
                <td align="center">' . $aGol['NOM_JUG'] . '</td>
                <td align="center">' . $aGol['APELLIDO1'] . '</td>
                <td align="center">' . $aGol['APELLIDO2'] . '</td>
                <td align="center">' . $aGol['NOM_EQUI'] . '</td>
                <td align="center">' . $aGol['GOL'] . '</td>
            </tr>';
        $nCont++;
    }
    ?>
</table>
<?php
include('sec/inc.footer.php');
?>