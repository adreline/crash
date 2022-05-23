<?php 
  $user = $_SESSION['protagonist']; 
  $pfp = Elements\Image::getImageById($user->images_id_image);
  $kudo_count = Elements\Kudo::countReceivedUserKudosById($user->id);
?>
<div class="navbar-item">
  <img class="avatar"  src=<?php echo "\"$pfp->path\""; ?> alt=<?php echo "\"$pfp->alt\""; ?>>
  <?php echo $user->username; ?>
</div>
<div class="navbar-item">
  <p>kudos: <?php echo $kudo_count; ?></p>
</div>
<a class="navbar-item" href="/crash/users/profile"><mark class="success">[profile]</mark></a>
<a class="navbar-item" href="/crash/users/scriptorium"><mark class="success">[go to author board]</mark></a>
<?php
//attach admin routes but only when the user have necessery privelage
if($user->administrator){
  echo "<a class=\"navbar-item\" href=\"/crash/admin\"><mark class=\"info\">[administrative]</mark></a>";
}
?>
<form class="navbar-item" action="/crash/users/logout" method="post">
  <button name="submit" type="submit"><mark class="danger">[logout]</mark></button>
</form>



