<div class="torneo_menu">
    <ul id="menu_second" class="">
        <li> <a href="./resultados.php?tor=<?php echo $sTorneoID; ?>">Resultados</a></li>
        <li><a href="./proxima.php?tor=<?php echo $sTorneoID; ?>">Proxima Fecha</a></li>
        <li class="has-sub">
            <a href="#">Fases</a>
            <ul>
                <li><a href="./grupos.php?tor=<?php echo $sTorneoID; ?>">Grupos</a> </li>
                <li><a href="./llaves.php?tor=<?php echo $sTorneoID; ?>">Llaves</a> </li>
            </ul>
        </li>
        <li class="has-sub">
            <a href="#">Estadisticas</a>
            <ul>
                <li class="has-sub"><a href="#">Tablas</a>
                    <ul>
                        <li class="has-sub"><a href="./tabla_grupos.php?tor=<?php echo $sTorneoID; ?>">Grupos</a></li>
                        <li class="has-sub"><a href="./tabla_general.php?tor=<?php echo $sTorneoID; ?>">General</a></li>
                    </ul>
                </li>
                <li class="has-sub"><a href="#">Controles</a>
                    <ul>
                        <li class="has-sub"><a href="./goleadores.php?tor=<?php echo $sTorneoID; ?>">Goleadores</a></li>
                        <li class="has-sub"><a href="./goleo_general.php?tor=<?php echo $sTorneoID; ?>">Goleo general</a></li>
                        <li class="has-sub"><a href="./est_jug_disc.php?tor=<?php echo $sTorneoID; ?>">Disiplina jugadores</a></li>
                        <li class="has-sub"><a href="./est_equi_disc.php?tor=<?php echo $sTorneoID; ?>">Disiplina equipos</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="./equipos.php?tor=<?php echo $sTorneoID; ?>">Equipos</a></li>
        <div class="clear"></div>
    </ul>
    <div class="clear"></div>
</div>
<div class="clear"></div>