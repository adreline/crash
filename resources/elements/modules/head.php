<?php
/**
 * This is global HEAD section
 * it loads dynamicly meta desc and title
 * */

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@100;400&family=Noto+Sans+JP:wght@700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/crash/public/css/silica.css">
    <script src="https://kit.fontawesome.com/36f98a2615.js" crossorigin="anonymous"></script>
    <?php 
        if (isset($page[0])) {
            echo $page[0]->custom_css;
            echo $page[0]->javascript;
        }
     ?>
</head>
