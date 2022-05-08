<?php
    use Crash\Crash as Crash;  
    use Elements\Page as Page;
?>

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
                    <li><a href="/crash/">Home</a></li>             
                    <?php
                        foreach (Page::getPage() as $page_l){
                            echo "<li><a href=\"/crash/$page_l->name\">$page_l->friendly_name</a></li>";
                        }
                    ?>
                    <li><a href="/crash/about">What is this?</a></li>
                </ul>
            </div>
</nav>
