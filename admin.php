<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Administration</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
       <?php 
        include('header.php');
        include('fonctions.php');
       ?>

        <?php
        /**
         * Etape 1: Ouvrir une connexion avec la base de donnée.
         */
        // on va en avoir besoin pour la suite
        include('pathRoot.php');
        //verification
        if ($mysqli->connect_errno)
        {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            exit();
        }
        ?>
        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>
                <?php
                /*
                 * Etape 2 : trouver tous les mots clés
                 */
                $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
                echecRequete($mysqli,$laQuestionEnSql);

                /*
                 * Etape 3 : @todo : Afficher les mots clés en s'inspirant de ce qui a été fait dans news.php
                 * Attention à en pas oublier de modifier tag_id=321 avec l'id du mot dans le lien
                 */
                while ($tag = $lesInformations->fetch_assoc())
                {
                    ?>
                    <article>
                        <h3>#<?php echo $tag['label'];?></h3>
                        <nav>
                            <?php $tagIdentifiant=$tag['id'];
                             echo'<a href="tags.php?tag_id='.$tagIdentifiant.'">Messages</a>'?>
                            
                        </nav>
                    </article>
                <?php } ?>
            </aside>
            <main>
                <h2>Utilisatrices</h2>
                <?php
                /*
                 * Etape 4 : trouver tous les mots clés
                 * PS: on note que la connexion $mysqli à la base a été faite, pas besoin de la refaire.
                 */
                $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
                echecRequete($mysqli,$laQuestionEnSql);

                /*
                 * Etape 5 : @todo : Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
                 * Attention à en pas oublier de modifier dans le lien les "user_id=123" avec l'id de l'utilisatrice
                 */
                while ($tag = $lesInformations->fetch_assoc())
                {
                    ?>
                    <article>
                        <h3><?php echo $tag['alias']?></h3>
                        <nav>
                            <?php $tagIdUser=$tag['id'];
                            echo'<a href="wall.php?user_id='.$tagIdUser.'"> Mur </a>';
                            echo'<a href="feed.php?user_id='.$tagIdUser.'"> Flux </a>';
                            echo'<a href="settings.php?user_id='.$tagIdUser.'"> Paramètres </a>';
                            echo'<a href="followers.php?user_id='.$tagIdUser.'"> Suiveurs </a>';
                            echo'<a href="subscriptions.php?user_id='.$tagIdUser.'"> Abonnements </a>';?>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
