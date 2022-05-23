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
  <div class="navbar-brand">
    <a class="navbar-item" href="/crash/">
        <div class="logo">
            <h1>Crash</h1>
            <h2>クラッシュ</h2>
        </div>
    </a>

    <a id="burger" class="navbar-burger">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="menu" class="navbar-menu">
    <div class="navbar-start">
        <a class="navbar-item" href="/crash/">[home]</a>        
        <?php
        foreach (Page::getAllPages() as $page_l){
            echo "<a class=\"navbar-item\" href=\"/crash/$page_l->name\">[$page_l->friendly_name]</a>";
        }
        if(isset($_SESSION['protagonist'])){
            echo "<div class=\"is-hidden-desktop\">";
            include Crash::$module['user_banner_mobile'];
            echo "</div>";
          }
        ?>
    
    </div>      
  </div>
</nav>

