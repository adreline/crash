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
                     echo "<h2 class=\"title\">You are editing $publication->title</h2>";
                    }else{
                     echo "<h2 class=\"title\">You are creating a new work</h2>";
                    }
                 ?>
                
                <div class="content">
                    <form action=<?php echo "\"$action\"" ?> method="post" enctype="multipart/form-data">
                        <?php 
                            if(isset($publication->id)){//if true then we are editing existing publication
                                echo "<input type=\"hidden\" name=\"id_publication\" value=\"$publication->id\">";
                            }
                        ?>
                        <input type="hidden" name="users_id_user" value=<?php echo "\"$protagonist->id\"" ?>>
                        <div class="field"><mark class="info">title:</mark><input type="text" name="title" value=<?php echo "\"$publication->title\"" ?>></div>
                        <div class="field"><mark class="info">uri:</mark><input type="text" name="uri" value=<?php echo "\"$publication->uri\"" ?>></div>
                        <div class="field"><mark class="info">cover:</mark><input type="file" name="image"></div>
                        <div class="field"><mark class="info">planned length:</mark><input type="number" name="planned_length" value=<?php echo "\"$publication->planned_length\"" ?>></div>
                        <div class="field"><mark class="info">status:</mark><select name="status">
                            <option value="0">ongoing</option>
                            <option value="1">finished</option>
                        </select></div>
                        <div class="field"><mark class="info">post inside fandom:</mark><input type="text" name="fandom_name" value=<?php echo "\"$fandom_name\"" ?>></div>
                        <div class="field"><mark class="info">prompt:</mark></div>
                        <div class="field"><textarea name="prompt" rows="10"><?php echo $publication->prompt; ?></textarea></div>
                        <div class="field"><mark class="info">tags:</mark></div>
                        <div class="field"><textarea name="tags" rows="10"><?php echo $tags; ?></textarea></div>
                        <button type="submit" name="submit"><mark class="success">[save]</mark></button>
                    </form>
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
