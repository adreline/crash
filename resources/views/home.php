
    <?php
        include Crash::$element['fandom'];
        include Crash::$element['leaflet'];
        include Crash::$element['publication'];
        include Crash::$element['user'];
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
                <h2>Popular fandoms</h2>
                <div class="content">
                   <?php
                        foreach(Fandom::getFandom() as $fandom){
                            echo "<p>>$fandom->friendly_name (<mark class=\"info\">2312</mark>)</p>";
                        }
                    ?>
 
                </div>
                </div>
                <div class="window">
                <h2>Recent works</h2>
                <div class="content">
                   <?php
                        foreach(Publication::getPublication(null,"LIMIT 4") as $publication){
                            $title=$publication->title;
                            $leafs=Leaflet::getLeaflet($publication->id);
                            if(sizeof($leafs)>0){
                                $prompt=substr($leafs[0]->body,0,100)."...";
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
