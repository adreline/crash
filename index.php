
    <?php
        require "resources/elements/app.php";
        include $modules['database'];
    ?>
<!DOCTYPE html>
    <?php
        include $modules['head'];
    ?>
    <body>
        <?php
            include $modules['navbar'];
        ?>
        <div class="columns">
            <div class="column">
               <?php  getTest(); ?>
            </div>
            <div class="column is-1-4">
                
            </div>
        </div>
    </body>
