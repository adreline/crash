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
                	<div class="window">
                	<h2 class="title">Confirm</h2>
                      <div class="content">
                        <p>Are you sure you want to delete your account? This action can not be undone.</p>
                        <div class="inline">
                            <a href="/crash/users/profile"><mark class="info">[no, go back]</mark></a>
                            <form method="post" action="/crash/users/delete">
                                <button type="submit"><mark class="info">[yes, delete]</mark></button>
                            </form>
                        </div>
                      </div>
                	</div>
    </body>
