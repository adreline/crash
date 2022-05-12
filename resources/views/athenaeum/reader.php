<?php
    use Crash\Crash as Crash;
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
                        <?php
                            foreach ($leafs as $leaf) {
                                echo "<h3>$leaf->title</h3>";
                                echo "<br>";
                                echo htmlspecialchars_decode($leaf->body, ENT_QUOTES);
                                echo "<br><br>";
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
