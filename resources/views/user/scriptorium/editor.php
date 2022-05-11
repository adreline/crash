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
                <?php
                    if(isset($publication->id)){//if true then we are editing existing publication
                     echo "<h2 class=\"title\">You are creating $publication->title</h2>";
                    }else{
                     echo "<h2 class=\"title\">You are creating a new work</h2>";
                    }
                 ?>
                
                <div class="content">
                    <form action=<?php echo "\"$action\"" ?> method="post">
                        <?php 
                            if(isset($publication->id)){//if true then we are editing existing publication
                                echo "<input type=\"hidden\" name=\"id_publication\" value=\"$publication->id\">";
                            }
                        ?>
                        <input type="hidden" name="users_id_user" value=<?php echo "\"$protagonist->id\"" ?>>
                        <p><mark class="info">title:</mark><input type="text" name="title" value=<?php echo "\"$publication->title\"" ?>></p>
                        <p><mark class="info">uri:</mark><input type="text" name="uri" value=<?php echo "\"$publication->uri\"" ?>></p>
                        <p><mark class="info">planned length:</mark><input type="number" name="planned_length" value=<?php echo "\"$publication->planned_length\"" ?>></p>
                        <p><mark class="info">status:</mark><select name="status">
                            <option value="0">ongoing</option>
                            <option value="1">finished</option>
                        </select></p>
                        <p><mark class="info">post inside fandom:</mark><input type="text" name="fandom_name" value=<?php echo "\"$publication->fandoms_id_fandom\"" ?>></p>
                        <button type="submit" name="submit"><mark class="success">[save]</mark></button>
                    </form>
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
