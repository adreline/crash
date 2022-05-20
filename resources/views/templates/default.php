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
                <h2 class="title"><?php echo "$page->friendly_name"; ?></h2>
                <div class="container">
                    <div class="content">
                        <?php echo "$page->content"; ?>
                    </div>
                </div>
                </div>
            </div>
            <div class="column is-1-4">
                <?php include Crash::$module['aside']; ?>
            </div>
        </div>
    </body>
