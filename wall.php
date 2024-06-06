<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php 
        include('header.php');
        include('fonctions.php');
       
       ?>
        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            $userId =intval($_GET['user_id'])
            
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
            include('pathRoot.php');
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                ?>
                <img src="img/user<?php echo $userId ?>.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les messages de l'utilisatrice : <?php echo $user['alias'];?>
                    </p>
                </section>
                <?php
                if($userId== $_SESSION['connected_id'])
                    {?>
                       
                       <section>
                    <h3>Message sur mon mur</h3>
                    <form action="wall.php?user_id=<?php echo $userId?>" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                            <dt><label for='message'></label></dt>
                            <dd><textarea name='message' placeholder="écris ton message ici"></textarea></dd>
                        </dl>
                        <input type='submit' class="btn">
                    </form>    
                </section>
                      <?php  
              }?>
                
               
                <?php
                /**
                     * TRAITEMENT DU FORMULAIRE
                     */
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['message']);
                    if ($enCoursDeTraitement)
                    {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                        //echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // et complétez le code ci dessous en remplaçant les ???
                        $wallAuthorId = $userId;
                        $postContent = $_POST['message'];


                        //Etape 3 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $postContent = $mysqli->real_escape_string($postContent);
                        //Etape 4 : construction de la requete
                        $lInstructionSql = "INSERT INTO posts "
                                . "(id, user_id, content, created, parent_id) "
                                . "VALUES (NULL, "
                                . $wallAuthorId . ", "
                                . "'" . $postContent . "', "
                                . "NOW(), "
                                . "NULL);"
                                ;
                        // Etape 5 : execution
                        $ok = $mysqli->query($lInstructionSql);
                        }?>
              

                <?php  
                
            ?>     
                 <?php 
            $laQuestionEnSql = "SELECT * FROM `followers` WHERE following_user_id=".$_SESSION['connected_id']." AND followed_user_id=".$userId."";
           
            $lesInformations = $mysqli->query($laQuestionEnSql);
            //var_dump($lesInformations->num_rows);
            // Vérification
            if ( $lesInformations->num_rows==0)
            {
                if($userId!= $_SESSION['connected_id'])
                {?>
                    <br>
                    <hr>
                    <form action="wall.php?user_id=<?php echo $userId?>" method="post">
                        <input type=submit name="abonnement" class="btn" value="S'abonner">
                    </form>
                  <?php  } ;

                  if (isset($_POST['abonnement'])) {
                      //Etape 4 : construction de la requete
                     $lInstructionSql = "INSERT INTO followers "
                    . "(id, followed_user_id,following_user_id) "
                
                                . "VALUES (NULL, "
                                . $userId . ", "
                                . $_SESSION['connected_id'].")"
                                ;
                 // Etape 5 : execution
                $ok = $mysqli->query($lInstructionSql);
                header("Location:wall.php?user_id=$userId");
                  };
            }else{?>
                    <br>
                    <hr>
                    <form action="wall.php?user_id=<?php echo $userId?>" method="post">
                        <span><input type=submit name="desabonnement" class="btn" value="Se désabonner"></span>
                    </form>
                  <?php   ;

                  if (isset($_POST['desabonnement'])) {
                      //Etape 4 : construction de la requete
                     $lInstructionSql = "DELETE FROM `followers` WHERE following_user_id=".$_SESSION['connected_id']." AND followed_user_id=".$userId."";
                                
                 // Etape 5 : execution
                $ok = $mysqli->query($lInstructionSql);
                header("Location:wall.php?user_id=$userId");
                  };

             

          }?>
            
          

                

            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    posts.user_id,
                    posts.id,
                    GROUP_CONCAT(DISTINCT tags.id,',',tags.label SEPARATOR';') AS taglist,
                    COUNT(likes.id) as like_number
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
               echecRequete($mysqli,$laQuestionEnSql);

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {
              
                    ?>        
                    <?php include('postUser.php');     ?>;   
                   
                <?php } ?>


            </main>
        </div>
    </body>
</html>
