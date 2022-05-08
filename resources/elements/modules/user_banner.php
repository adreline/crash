<?php $user = $_SESSION['protagonist']; ?>
<div class="window">
<h2 class="title"><?php echo $user->username; ?></h2>
  <div class="content">
    <div class="columns">
    <div class="column is-1-4">
      <img class="avatar" src="/crash/public/img/avi_placeholder.jpg">
    </div>
    <div class="column">
      <p>Followers: n/a</p>
      <p>Kudos: n/a</p> 
      <div class="inline">
        <form action="/crash/users/logout" method="post">
          <button name="submit" type="submit"><mark class="danger">Logout</mark></button>
        </form>
        <a href="/crash/users/profile"><mark class="success">Profile</mark></a>
      </div>
       <?php
          //attach admin routes but only when the user have necessery privelage
        if($user->privelage){
          echo "<a href=\"/crash/admin\"><mark class=\"info\">Administrative</mark></a>";
        }
       ?>
    </div>
    </div>
    <p>Recent activity</p>
  </div>
</div>
