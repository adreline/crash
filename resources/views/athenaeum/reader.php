<?php
    use Crash\Crash as Crash;
    use Elements\Kudo;
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
                                <img src=<?php echo "\"/crash/public/img/placeholder.jpg\""; ?>>
                            </div>
                            <div class="column flex">
                                <div class="align-bottom flex stretch max-width">
                                    <p>kudos (<mark class="info"><?php echo $kudo_count; ?></mark>)</p>
                                    <p>status (<mark class="info"><?php echo $pub_status; ?></mark>)</p>
                                    <p>chapters (<mark class="info"><?php echo sizeof($leafs); ?></mark>/<mark class="info"><?php echo $publication->planned_length; ?></mark>)</p>
                                    <p>by <mark class="success"><?php echo $pub_author; ?></mark></p>
                                    <?php 
                                    if(!Kudo::kudoExists($p->id,$publication->id)){
                                        echo "<a href=\"/crash/athenaeum/kudo/give?id_user=$p->id&id_publication=$publication->id\"><mark class=\"success\">[leave kudo]</mark></a>"; 
                                    }else{
                                        echo "<a href=\"/crash/athenaeum/kudo/withdraw?id_user=$p->id&id_publication=$publication->id\"><mark class=\"danger\">[withdraw kudo]</mark></a>"; 
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
                            <form action="/crash/athenaeum/comment/post" method="post">
                                <input type="hidden" name="id_user" value=<?php echo "\"$p->id\"" ?>>
                                <input type="hidden" name="id_publication" value=<?php echo "\"$publication->id\"" ?>>
                                <div class="field"><mark class="info">leave a comment</mark></div> 
                                <div class="field"><textarea cols="50" rows="10" name="body"></textarea></div> 
                                <div class="field"><button type="submit"><mark class="success">[submit]</mark></button></div> 
                            </form>
                    </div>
                </div>
            </div>
            <div class="column is-1-4">
                <?php include Crash::$module['aside']; ?>
            </div>
        </div>
    </body>
