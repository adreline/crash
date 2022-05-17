
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
                <h2 class="title">Search results</h2>
                <div class="content">
                   <?php
                        foreach($publications as $publication){
                            $leafs=E\Leaflet::getLeaflet($publication->id);
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
