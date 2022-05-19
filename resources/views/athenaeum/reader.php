<?php
    use Crash\Crash as Crash;
    use Elements\Kudo;
    use Elements\User;
    $p = $_SESSION['protagonist'];
?>
<!DOCTYPE html>
<?php
    include Crash::$module['head'];
?>
    <body>
    <?php
        include Crash::$module['navbar'];
    ?>
        <div class="columns">
            <div class="column">
                <div class="window">
                    <h2 class="title"><?php echo "$publication->title"; ?></h2>
                    <div class="content">
                        <div class="columns">
                            <div class="column is-1-3">
                                <img src=<?php echo "\"$cover->path\""; ?> alt=<?php echo "\"$cover->alt\""; ?>>
                            </div>
                            <div class="column grid">
                                <div class="content">
                                    <h4>tags</h4>
                                    <?php
                                        foreach($tags as $tag){
                                            echo "$tag->friendly_name (n/a) ";
                                        }
                                    ?>
                                    <h4>summary</h4>
                                    <?php echo $publication->prompt; ?>
                                </div>
                                <div class="align-bottom flex stretch max-width">
                                    <p>kudos (<mark class="info"><?php echo $kudo_count; ?></mark>)</p>
                                    <p>status (<mark class="info"><?php echo $pub_status; ?></mark>)</p>
                                    <p>chapters (<mark class="info"><?php echo sizeof($leafs); ?></mark>/<mark class="info"><?php echo $publication->planned_length; ?></mark>)</p>
                                    <p>by <mark class="success"><?php echo $pub_author; ?></mark></p>
                                    <?php 
                                    if(isset($p) && $publication->users_id_user != $p->id){//if user is logged in and user is not the author
                                        if(!Kudo::kudoExists($p->id,$publication->id)){
                                            echo "<a href=\"/crash/athenaeum/kudo/give?id_user=$p->id&id_publication=$publication->id\"><mark class=\"success\">[leave kudo]</mark></a>"; 
                                        }else{
                                            echo "<a href=\"/crash/athenaeum/kudo/withdraw?id_user=$p->id&id_publication=$publication->id\"><mark class=\"danger\">[withdraw kudo]</mark></a>"; 
                                        } 
                                    }
                                                                  
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content chapter">
                        <?php
                            foreach ($leafs as $i => $leaf) {
                                $i++;
                                echo "<h3>Chapter $i</h3>";
                                echo "<h4>$leaf->title</h4>";
                                echo "<span class=\"horizontal-line\"></span>";
                                echo $leaf->body;
                            } 
                        ?>
                
                    </div>
                </div>
                <div class="window">
                        <h2 class="title">comments</h2>
                        <div class="content">
                            <?php if(isset($p)) include Crash::$module['comment_form']; ?>
                        </div>
                        <div class="content">
                            <?php 
                                foreach($comments as $comment){
                                    
                                    $comment_body = $comment->body;
                                    $comment_author = User::getUserById($comment->users_id_user);
                                    $pfp = Elements\Image::getImageById($comment_author->images_id_image);
                                    include Crash::$module['comment'];
                                }
                                
                            ?>
                        </div>
                </div>
            </div>
            <div class="column is-1-4">
                <?php include Crash::$module['aside']; ?>
            </div>
        </div>
    </body>
