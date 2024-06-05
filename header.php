<?php session_start() ;
include('police.php');?>

<header>
            <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
            <?php
            if (isset($_SESSION['connected_id'])){?>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?php echo $_SESSION['connected_id']?>">Mur</a>
                <a href="feed.php?user_id=<?php echo $_SESSION['connected_id']?>">Flux</a>
                <a href="tags.php?tag_id=<?php echo $_SESSION['connected_id']?>">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">▾ Bonjour <?php echo  $_SESSION['connected_alias']?> </a>
                <ul>
                    <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id']?>">Paramètres</a></li>
                    <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes abonnements</a></li>
                    <li><a href="logout.php">Deconnexion</a></li>
                </ul>
            </nav>
            <?php }else{?>
            <nav id="inscription" >
                <a href="registration.php">Inscription</a>
                <a href="login.php">Connexion</a>
            </nav>
            <?php }?>
           
</header>