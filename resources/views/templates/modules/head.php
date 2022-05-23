<?php
/**
 * This is global HEAD section
 * it loads dynamicly meta desc and title
 * */

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
            if(!isset($head)) global $head;
            echo "<title>$head->title</title>";
            echo "<meta name=\"description\" content=\"$head->desc\">";
            echo "<meta name=\"robots\" content=\"$head->robots\">"; 
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@100;400&family=Noto+Sans+JP:wght@700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/crash/public/css/silica.css">
    <link rel="icon" type="image/x-icon" href="/crash/favicon.svg">
    <?php 
        if (isset($page)) {
            echo $page->custom_css;
            echo $page->javascript;
        }
        
     ?>
     <script src="/crash/public/js/mobile-navbar.js"></script>
</head>
