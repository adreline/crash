<?php $user = $_SESSION['protagonist']; ?>
<div class="window">
<h2><?php echo $user->username; ?></h2>
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
        <form action="/crash/users/profile" method="post">
          <button name="submit" type="submit"><mark class="success">Profile</mark></button>
        </form>
      </div>
    </div>
    </div>
    <p>Recent activity</p>
  </div>
</div>
