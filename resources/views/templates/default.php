<!DOCTYPE html>
    <?php
        use Crash\Crash as Crash;
        include Crash::$module['head'];
    ?>
    <body>
        <?php
            include Crash::$module['navbar'];
        ?>
        <div class="columns">
            <div class="column">
                <div class="window">
                <h2><?php echo "$page->friendly_name"; ?></h2>
                <?php echo "$page->content"; ?>
                </div>
            </div>
            <div class="column is-1-4">
                
            </div>
        </div>
    </body>
