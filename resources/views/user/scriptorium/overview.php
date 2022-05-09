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
                        foreach([1,2,3] as $i){
                            echo "<mark class=\"info\">Title:</mark> some title | ";
                            echo "<a href=\"#\"><mark class=\"info\">[edit]</mark></a> <a href=\"#\"><mark class=\"danger\">[delete]</mark></a>";
                            echo "<br>";
                        }
                    ?></p>
                    <h4>Tasks</h4>
                    <a><mark class="success">[start new work]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
