
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
                        foreach(E\Fandom::getFandom() as $fandom){
                            echo "<p>>$fandom->friendly_name (<mark class=\"info\">2312</mark>)</p>";
                        }
                    ?>
 
                </div>
                </div>
                <div class="window">
                <h2 class="title">Recent works</h2>
                <div class="content">
                   <?php
                        foreach(E\Publication::getPublication(null,"ORDER BY created_at DESC LIMIT 4") as $publication){
                            $title=$publication->title;
                            $leafs=E\Leaflet::getLeaflet($publication->id);
                            if(sizeof($leafs)>0){
                                $prompt=substr(htmlspecialchars_decode($leafs[0]->body,ENT_QUOTES),0,100)."...";
                            }else{
                                $prompt="...";
                            }
                            
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
