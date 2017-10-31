<?php
include 'inc.head.php';

$sql = "SELECT * FROM t_torneo WHERE MOSTRAR=1";
$query = mysql_query($sql, $conn);
?>
<div class="container ">
    <h1>Torneos</h1>
    <hr/>
    <p>Los torneos a continuacion son los torneos en curso:</p>
    <ul class="torneo_list">

        <?php
        while ($row = mysql_fetch_assoc($query)) {
            ?>
            <li>
                <a href="./resultados.php?tor=<?php echo $row['ID']; ?>" >
                    <p><?php echo $row['NOMBRE']; ?></p>
                    <p><?php echo $row['YEAR']; ?></p>
                </a>
            </li>
            <?php
        }
        ?>

    </ul>
    <div class="clear"></div>
</div>
<?php
include 'inc.footer.php';
?>