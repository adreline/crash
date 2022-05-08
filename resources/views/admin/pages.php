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
                <h2>Manage pages</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column">

                        </div>
                        <div class="column">

                        </div>
                    </div>
                    <h5>Existing pages</h5>
                    <p><?php 
                        foreach($pages as $page){
                            echo "<mark class=\"info\">Title:</mark> $page->friendly_name | ";
                            echo "<mark class=\"info\">Uri:</mark> $page->name | ";
                            echo "<a href=\"/crash/admin/pages/edit?id=$page->id\"><mark class=\"info\">[edit]</mark></a> <a href=\"/crash/admin/pages/delete?id=$page->id\"><mark class=\"danger\">[delete]</mark></a>";
                            
                        }
                    ?></p>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
