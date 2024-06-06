<article>
    <h3>
        <time><?php 
            //echo "<pre>" . print_r($post, 1) . "</pre>";
            //echo "<pre>" . print_r($tags, 1) . "</pre>";
            if(isset($post['created'])){
            $time = strtotime($post['created']);
            $newformat = date('d/m/Y à H:i',$time);
            echo $newformat ;}?></time>
    </h3>
    <?php 
    if ((isset($post['user_id']))&&(isset($post['author_name']))){?>
    <a href="wall.php?user_id=<?php echo $post['user_id']?>">
    <address> par <?php echo $post['author_name']?></address></a>
    <div>
        <p><?php echo $post['content']?></p>
    </div>
    <?php };?>
    <footer>
        <?php 
            if(isset($userId)||$userId!= $_SESSION['connected_id']){
                if (isset($post['like_number'])){  
                ?>
                    <br>
                    <hr>
                    <form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>" method="post">
                                               
                        <small><input type=submit name="like" value="♥" id="heart"></small>
                        <!-- pour permettre de récupérer la valeur du post et qu'on puisse like le bon post -->
                        <?php if(isset($post['id'])){?>
                        <input type="hidden" name='id' value="<?= $post['id']?>">
                        <small id="nbrLike"><?php echo $post['like_number'];}}?> </small>
                    </form>
                  <?php  } ;
                if(isset($_POST['like'])){
                     // gestion des likes
             $userId =intval($_GET['user_id']);
             $laQuestionEnSql = "SELECT * FROM `likes` WHERE user_id=".$_SESSION['connected_id']." AND post_id=".$_POST['id']."";
            //echo $laQuestionEnSql;
             $lesInformations = $mysqli->query($laQuestionEnSql);
             //var_dump($lesInformations);die;
             //var_dump($lesInformations);die;
             // Vérification
                 if($lesInformations->num_rows==0){

                    //Etape 4 : construction de la requete
                     $lInstructionSql = "INSERT INTO likes "
                    . "(id, user_id,post_id) "
                    . "VALUES (NULL, "
                    . $_SESSION['connected_id'] . ", "
                    . $_POST['id'].")"
                    ;

                 // Etape 5 : execution
                $ok = $mysqli->query($lInstructionSql);   
                header("Location:wall.php?user_id=$userId");        
                  }else{
                    //Etape 4 : construction de la requete
                    $lInstructionSql = "DELETE FROM `likes` WHERE user_id=".$_SESSION['connected_id']." AND post_id=".$_POST['id']."";
                     //var_dump($lInstructionSql);die;       
                        // Etape 5 : execution
                    $ok = $mysqli->query($lInstructionSql);
                    header("Location:wall.php?user_id=$userId");
                    //$host  = $_SERVER['HTTP_HOST'];
                  // $uri=$_SERVER['REQUEST_URI'];
                    //header("Location:http://$host$uri")
                    

                    //<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
                   
                    //$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    //$extra = 'mypage.php';
                    //header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                  
                 }
            }
                
            ?>
           
            <?php 
            // gestion des tags
          
            if(isset($post['taglist'])) {
           $tags=explode(";",(string)$post['taglist']);}; 

            if(isset($tags)) {      
            foreach($tags as $tag){
                $tab=explode(",",$tag);
                $tab_id=$tab[0];
                $tab_label=$tab[1];}
                ?>
             <a href="tags.php?tag_id=<?php echo $tab_id?>" id="hastag">#<?php echo $tab_label;?></a>
             <?php }?>
             
    </footer>
</article>