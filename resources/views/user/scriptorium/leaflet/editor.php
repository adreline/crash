<?php
    use Crash\Crash as Crash;
    use Elements as E;
    $protagonist = $_SESSION['protagonist'];//a shorthand
?>
<!DOCTYPE html>
<?php
    include Crash::$module['head'];
?>
    <body>
    <?php
        include Crash::$module['navbar'];
    ?>
        <form action=<?php echo "\"$action\"" ?> method="post">
        <div class="columns">
            <div class="column">
                <div class="window">
                <?php
                    if(isset($leaf)){//if true then we are editing existing leaflet 
                     echo "<h2 class=\"title\">You are editing chapter $leaf->id in $publication->title</h2>";
                     echo "<input type=\"hidden\" name=\"id_leaf\" value=\"$leaf->id\">";
                    }else{
                     echo "<h2 class=\"title\">You are writting a new page in $publication->title</h2>";
                    }
                 ?>
                    <textarea id="editor" name="body" rows="40" cols="50">
                        <?php if(isset($leaf)) echo $leaf->body; ?>
                    </textarea>
                <div class="content">
                    <p><mark class="info">chapter title:</mark><input type="text" name="title" value="<?php if(isset($leaf)) echo $leaf->title; ?>"></p>
                    <input type="hidden" name="id_publication" value="<?php echo $publication->id; ?>">
                    <button type="submit" name="submit"><mark class="success">[save]</mark></button>
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
        <div class="columns">
            <div class="column">
                
            </div>
            <div class="column is-1-4">

            </div>
        </div>
        </form>
        <link rel="stylesheet" href="/crash/public/css/leafeditor.css">
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
        </script>
    </body>
