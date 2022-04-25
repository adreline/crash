<?php
    header('HTTP/1.1 404 Not Found');
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
                	<div class="window">
                	<h2>Error 404</h2>
                      <div class="content">
                        <p>Requested page has not been found</p>
                      </div>
                	</div>
    </body>
