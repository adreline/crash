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
                <h2 class="title">You are creating a new work</h2>
                <div class="content">
                    <form action=<?php echo "\"$action\"" ?> method="post">
                        <?php 
                            if(isset($publication->id)){//if true then we are editing existing publication
                                echo "<input type=\"hidden\" name=\"id_publication\" value=\"$publication->id\">";
                            }
                        ?>
                        <input type="hidden" name="users_id_user" value=<?php echo "\"$protagonist->id\"" ?>>
                        <p><mark class="info">title:</mark><input type="text" name="title"></p>
                        <p><mark class="info">planned length:</mark><input type="number" name="planned_length"></p>
                        <p><mark class="info">status:</mark><select name="status">
                            <option value="0">ongoing</option>
                            <option value="1">finished</option>
                        </select></p>
                        <p><mark class="info">post inside fandom:</mark><input type="text" name="fandom_name"></p>
                        <button type="submit" name="submit"><mark class="success">[save]</mark></button>
                    </form>
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
