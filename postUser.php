<article>
    <h3>
        <time><?php 
            $time = strtotime($post['created']);
            $newformat = date('d/m/Y à H:i',$time);
            echo $newformat ?></time>
    </h3>
    <a href="wall.php?user_id=<?php echo $post['user_id']?>">
    <address> par <?php echo $post['author_name']?></address></a>
    <div>
        <p><?php echo $post['content']?></p>
    </div>
    <footer>
        <small>♥ <?php echo $post['like_number']?> </small>
            <?php
            //transforme en tableau la chaine de caractères des tags, idem fct split en js
            $tagHastagList=explode(",",$post['taglist']);
            foreach ($tagHastagList as &$tag){
            ?>
            <a href="">#<?php echo $tag;?></a>
            <?php
            }?>
    </footer>
</article>