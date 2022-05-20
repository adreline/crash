<?php
    use Crash\Crash as Crash;  
    use Elements\Page as Page;
?>
<?php 
    //check if there are any notifications to display
    if(isset($_COOKIE['notification'])){
        $n=explode(";",$_COOKIE['notification']);
        Crash::notify($n[0],$n[1]);
    }
?>
<nav class="navbar">
            <a href="/crash/">
                <div class="logo">
                    <h1>Crash</h1>
                    <h2>クラッシュ</h2>
                </div>
            </a>
            <div class="container">
                <div class="search-box">
                    <form method="get" action="/crash/search">
                        <div class="field">maddieuwu@search<mark class="info">:</mark>~<mark class="info">$</mark><input type="text" name="query"></div>
                    </form>
                </div>
                <ul>
                    <li><a href="/crash/">[home]</a></li>             
                    <?php
                        foreach (Page::getAllPages() as $page_l){
                            echo "<li><a href=\"/crash/$page_l->name\">[$page_l->friendly_name]</a></li>";
                        }
                    ?>
                    <li><a href="/crash/about">[what is this?]</a></li>
                </ul>
            </div>
</nav>
