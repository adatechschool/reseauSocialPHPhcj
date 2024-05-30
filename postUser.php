<?php 
$tags=explode(";",$post['taglist']);
?>

<article>
    <h3>
        <time><?php 
            //echo "<pre>" . print_r($post, 1) . "</pre>";
            //echo "<pre>" . print_r($tags, 1) . "</pre>";
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
            foreach($tags as $tag){
                $tab=explode(",",$tag);
                $tab_id=$tab[0];
                $tab_label=$tab[1];
                ?>
             <a href="tags.php?tag_id=<?php echo $tab_id?>">#<?php echo $tab_label;?></a> 
             <?php
          }?>
    </footer>
</article>