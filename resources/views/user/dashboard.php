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
                <h2 class="title"><?php echo $protagonist->username; ?> dashboard</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column is-1-4">
                            <img class="avatar" src="/crash/public/img/avi_placeholder.jpg">
                        </div>
                        <div class="column">
                            <p>this is pog test</p>
                            <p>anotherer tetst</p>
                            <p>some tetst</p>
                        </div>
                    </div>
                    <h4>Tasks</h4>
                    <a><mark class="success">[change username]</mark></a>
                    <a><mark class="success">[change password]</mark></a>
                    <a><mark class="success">[change avatar]</mark></a>
                    <a href="/crash/users/scriptorium"><mark class="success">[go to author board]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
