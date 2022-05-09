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
                     echo "<h2 class=\"title\">You are editing page in $publication->title</h2>";
                    }else{
                     echo "<h2 class=\"title\">You are writting a new page in $publication->title</h2>";
                    }
                 ?>
                
                <div class="content">
    
              
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="document-editor">
                    <div class="document-editor__toolbar"></div>
                    <div class="document-editor__editable-container">
                        <div class="document-editor__editable" name="body">
                            
                        </div>
                    </div>
                </div>

            </div>
            <div class="column is-1-4">

            </div>
        </div>
        </form>
        <link rel="stylesheet" href="/crash/public/css/leafeditor.css">
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/decoupled-document/ckeditor.js"></script>
        <script>
            DecoupledEditor
                .create( document.querySelector( '.document-editor__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    window.editor = editor;
                } )
                .catch( err => {
                    console.error( err );
                } )

        </script>
    </body>
