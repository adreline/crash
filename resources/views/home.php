
    <?php
        use Crash\Crash as Crash;
        use Elements as E;
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
                <h2 class="title">Popular fandoms</h2>
                <div class="content">
                   <?php
                        $fandoms=E\Fandom::getActiveFandoms();
                        if($fandoms instanceof E\Fandom){
                            echo "<p>>$fandoms->friendly_name (<mark class=\"info\">2312</mark>)</p>";
                        }else{
                            foreach($fandoms as $fandom){
                                echo "<p>>$fandom->friendly_name (<mark class=\"info\">2312</mark>)</p>";
                            }
                        }
                        
                    ?>
 
                </div>
                </div>
                <div class="window">
                <h2 class="title">Recent works</h2>
                <div class="content">
                   <?php
                        foreach(E\Publication::getAllPublications("ORDER BY created_at DESC LIMIT 4") as $publication){
                            $kudos=E\Kudo::countPublicationKudosById($publication->id);
                            $image=E\Image::getImageById($publication->images_id_image);
                            $comments=sizeof(E\Comment::getPublicationComments($publication->id));
                            include Crash::$module['post'];
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
