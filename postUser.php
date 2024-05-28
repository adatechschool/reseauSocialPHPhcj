<article>
                        <h3>
                            <time><?php 
                            $time = strtotime($post['created']);
                            $newformat = date('d/m/Y à H:i',$time);
                            echo $newformat ?></time>
                            
                        </h3>
                        <address>par <?php echo $post['author_name']?></address>
                        <div>
                            <p><?php echo $post['content']?></p>
                        </div>
                        <footer>
                            <small>♥ <?php echo $post['like_number']?> </small>
                            <a href="">#<?php 
                                $tagHashtag=$post['taglist'];
                                //transforme en tableau la chaine de caractères des tags, idem fct split en js
                                $tagHastagList=explode(",",$tagHashtag);
                                echo $tagHastagList[0];
                            ?></a><?php 
                                if(isset($tagHastagList[1]))
                                {
                                    ?><a href="">, #<?php 
                                    echo $tagHastagList[1];
                                }
                            ?></a><?php 
                            if(isset($tagHastagList[2]))
                            {
                                ?><a href="">, #<?php 
                                echo $tagHastagList[2];
                            }
                        ?></a>
                        </footer>
                    </article>