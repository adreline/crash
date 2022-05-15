<?php
/**
 * This is global HEAD section
 * it loads dynamicly meta desc and title
 * */

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        if(isset($head)){
            echo "<title>$head->title</title>";
            echo "<meta name=\"description\" content=\"$head->desc\">";
        }else{
            echo "<title>Crash</title>";
        }
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@100;400&family=Noto+Sans+JP:wght@700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/crash/public/css/silica.css">
    <link rel="icon" type="image/x-icon" href="/crash/favicon.svg">
    <script src="https://kit.fontawesome.com/36f98a2615.js" crossorigin="anonymous"></script>
    <?php 
        if (isset($page)) {
            echo $page->custom_css;
            echo $page->javascript;
        }
        
     ?>
</head>
