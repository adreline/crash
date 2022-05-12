<?php
    use Crash\Crash as Crash;
    use Elements as E;
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
                <h2 class="title"><?php echo "You are editing $page->friendly_name"; ?></h2>
                <form action=<?php echo "\"$action\""; ?> method="post">
                <textarea id="editor" name="content" rows="4" cols="50"><?php echo "$page->content"; ?></textarea>
                <div class="content">
                    
                        <input type="hidden" name="id_page" value=<?php echo "\"$page->id\""; ?>>
                        <p><mark class="info">title:</mark> <input type="text" name="friendly_name" value=<?php echo "\"$page->friendly_name\""; ?>></p>
                        <p><mark class="info">url:</mark>/crash/<input type="text" name="name" value=<?php echo "\"$page->name\"" ?>></p>
                        <p><mark class="info">CSS:</mark></p>
                        <p><textarea id="css-editor" name="custom_css" rows="4" cols="50"><?php echo "$page->custom_css"; ?></textarea></p>
                        <p><mark class="info">JS:</mark></p>
                        <p><textarea id="js-editor" name="javascript" rows="4" cols="50"><?php echo "$page->javascript"; ?></textarea></p>
                        <button type="submit" name="submit"><mark class="success">[save]</mark></button>
                    
                </div>
                </form>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
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
