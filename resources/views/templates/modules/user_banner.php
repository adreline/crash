<?php 
$user = $_SESSION['protagonist']; 
$pfp = Elements\Image::getImageById($user->images_id_image);
$kudo_count = Elements\Kudo::countReceivedUserKudosById($user->id);
?>
<div class="window">
<h2 class="title"><?php echo $user->username; ?></h2>
  <div class="content">
    <div class="columns">
    <div class="column is-1-4">
      <img class="avatar"  src=<?php echo "\"$pfp->path\""; ?> alt=<?php echo "\"$pfp->alt\""; ?>>
    </div>
    <div class="column">
      <p>Followers: n/a</p>
      <p>Kudos: <?php echo $kudo_count; ?></p> 
      <div class="grid">
        <a href="/crash/users/profile"><mark class="success">[profile]</mark></a>
        <a href="/crash/users/scriptorium"><mark class="success">[go to author board]</mark></a>
        <?php
          //attach admin routes but only when the user have necessery privelage
        if($user->administrator){
          echo "<a href=\"/crash/admin\"><mark class=\"info\">[administrative]</mark></a>";
        }
       ?>
       <form action="/crash/users/logout" method="post">
          <button name="submit" type="submit"><mark class="danger">[logout]</mark></button>
        </form>
      </div>
    </div>
    </div>
    <p>Recent activity</p>
  </div>
</div>
