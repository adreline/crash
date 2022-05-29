
    <?php
        use Crash\Crash as Crash;
        use Elements as E;
    ?>
<!DOCTYPE html>


    <body>
        <?php
            include Crash::$module['navbar'];
        ?>
        <div class="columns">
            <div class="column">
                <div class="window">
                <h2 class="title">Popular fandoms</h2>
                <div class="content cloud">
                   <?php
                        foreach(E\Fandom::getPopularFandoms() as $struct){
                            $fandom = $struct->fandom;
                            if($fandom->active) echo "<a href=\"/crash/fandom/$fandom->name\">[$fandom->friendly_name] (<mark class=\"info\">$struct->size</mark>)</a>";
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
