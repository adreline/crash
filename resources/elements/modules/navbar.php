<?php include_once Crash::$element['page']; ?>
<nav class="navbar">
            <div class="logo">
                <h1>Crash</h1>
                <h2>クラッシュ</h2>
            </div>
            <div class="container">
                <div class="search-box">
                    <p>maddieuwu@search<mark class="info">:</mark>~<mark class="info">$</mark><input type="text"></p>
                </div>
                <ul>
                    <li><a href="http://niecko.4suns.pl/crash/">Home</a></li>
                    <?php
                        foreach (Page::getPage() as $page){
                            echo "<li><a class=\"is-active\" href=\"$page->name\">$page->friendly_name</a></li>";
                        }
                    ?>
                </ul>
            </div>
</nav>