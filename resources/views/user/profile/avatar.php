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
                <h2 class="title"><?php echo $protagonist->username; ?> - change your profile image</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column is-1-4">
                            <form action="/crash/users/avatar" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_user" value=<?php echo "\"$protagonist->id\""; ?>>
                                <div class="field"><mark class="info">new image:</mark> <input type="file" name="image"></div>
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
