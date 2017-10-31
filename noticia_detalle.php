
<?php
include 'inc.head.php';

$sql = "SELECT * FROM t_noticias WHERE ID=" . $_GET['id'];
$query = mysql_query($sql, $conn);
$row = mysql_fetch_assoc($query);
?>
<div class="container ">
    <h1>Noticias</h1>
    <hr/>
    <div class="noti_main">
        <img src="<?php echo 'admin/noticias/' . $row['URL_IMAGEN']; ?>" >
        <h2><?php echo $row['TITULO']; ?></h2>
        <h5><?php echo $row['FECHA']; ?></h5>
        <p><?php echo $row['DESCRIPCION_CORTA']; ?></p>
        <br/>
        <div id="fb-root" align="center"></div>
        <script src="http://connect.facebook.net/en_US/all.js#appId=APP_ID&amp;xfbml=1"></script>
        <fb:comments numposts="10" width="700" publish_feed="true"></fb:comments>
        <script src="http://connect.facebook.net/en_US/all.js#appId=264887889270&amp;xfbml=1"></script>

    </div>
    <div class="noti_right_bar">
        <h3>Mas Noticias</h3>
        <?php
        $sql = "SELECT * FROM t_noticias WHERE ID!=" . $_GET['id'] . " ORDER BY ID DESC LIMIT 0,4";
        $query = mysql_query($sql, $conn);

        while ($row = mysql_fetch_assoc($query)) {
            ?>

            <table border="0" >
                <tr>
                    <td>
                        <a href="noticia_detalle.php?id=<?php echo $row['ID'] . '&pg=' . $_GET['pg']; ?>">
                            <img src="admin/noticias/<?php echo $row['URL_IMAGEN']; ?>" width="150px">
                        </a>
                    </td>
                    <td>
                        <a href="noticia_detalle.php?id=<?php echo $row['ID'] . '&pg=' . $_GET['pg']; ?>">
                            <?php echo $row['TITULO']; ?>
                        </a>
                        <h5><?php echo $row['FECHA']; ?></h5>
                    </td>
                </tr>
            </table>

            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
</div>
<?php
include 'inc.footer.php';
?>