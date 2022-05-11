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
                <h2 class="title"><?php echo $protagonist->username; ?> - change your password</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column is-1-4">
                            <form action=<?php echo "\"/crash/users/password\""; ?> method="post">
                                <input type="hidden" name="id_user" value=<?php echo "\"$protagonist->id\""; ?>>
                                <p><mark class="info">new password:</mark> <input type="password" name="new_pass"></p>
                                <button type="submit" name="submit"><mark class="success">[save]</mark></button>
                            </form>
                        </div>
                        <div class="column">
 
                        </div>
                    </div>

                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
