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
                    <h2 class="title">you are requesting a new fandom</h2>
                
                <div class="content">
                    <form action="/crash/users/fandom/request" method="post">
                        <div class="field"><mark class="info">name:</mark><input type="text" name="friendly_name" placeholder="full name of the fandom"></div>
                        <div class="field"><mark class="info">uri:</mark>/crash/<input type="text" name="name" placeholder="can be left empty"></div>
                        <button type="submit" name="submit"><mark class="success">[send]</mark></button>
                    </form>
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
