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
                	<h2>Error <?php if(isset($code)) echo $code; ?></h2>
                      <div class="content">
                        <p><?php if(isset($msg)) echo $msg; ?></p>
                      </div>
                	</div>
    </body>
