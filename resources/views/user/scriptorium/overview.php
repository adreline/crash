<?php
    use Crash\Crash as Crash;
    use Elements as E;
    $protagonist = $_SESSION['protagonist'];
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
                <h2 class="title"><?php echo $protagonist->username; ?> works</h2>
                <div class="content">
                    <h4>Published works</h4>
                    <p><?php 
                        foreach(E\User::getUserPublications($protagonist->id) as $pub){
                            $published_pages=$pub->getPublicationLeafs($pub->id);
                            $number_of_published_pages=sizeof($published_pages);
                            echo "<mark class=\"info\">title:</mark> $pub->title | ";
                            echo "<mark class=\"info\">status:</mark> $pub->status | ";
                            echo "<mark class=\"info\">published pages:</mark> $number_of_published_pages | ";
                            echo "<a href=\"/crash/users/scriptorium/leaflet?id=$pub->id\"><mark class=\"success\">[see pages]</mark></a> <a href=\"#\"><mark class=\"info\">[edit]</mark></a> <a href=\"#\"><mark class=\"danger\">[delete]</mark></a>";
                            echo "<br>";
                        }
                    ?></p>
                    <h4>Tasks</h4>
                    <a href="/crash/users/scriptorium/publication/editor"><mark class="success">[start new work]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">
                
            </div>
        </div>
    </body>
