<?php
    use Crash\Crash as Crash;
    use Elements as E;
    $protagonist = $_SESSION['protagonist'];
?>
<!DOCTYPE html>
<?php
    include Crash::$module['head'];
?>
    <body>
    <?php
        include Crash::$module['navbar'];
    ?>
        <div class="columns">
            <div class="column">
                <div class="window">
                <h2 class="title"><?php echo $protagonist->username; ?></h2>
                <div class="content">
                    <div class="columns">
                        <div class="column is-1-4">
                            <img class="avatar" src="/crash/public/img/avi_placeholder.jpg">
                        </div>
                        <div class="column">
                            <p>kudos: <mark class="info"><?php echo E\Kudo::countReceivedUserKudosById($protagonist->id); ?></mark></p>
                            <p>works: <mark class="info"><?php echo E\User::getUserPublicationsCount($protagonist->id); ?></mark></p>
                            <p>followers: <mark class="info">0</mark></p>
                            <p>on crash since: <mark class="info"><?php echo $protagonist->created_at; ?></mark></p>
                            <a href="/crash/users/delete"><mark class="danger">[delete your account]</mark></a>
                        </div>
                        <div class="column">
                            <ul>
                                <li><a href="/crash/users/username"><mark class="success">[change username]</mark></a></li>
                                <li><a href="/crash/users/password"><mark class="success">[change password]</mark></a></li>
                                <li><a><mark class="success">[change avatar]</mark></a></li>
                                <li><a href="/crash/users/scriptorium"><mark class="success">[go to author board]</mark></a></li>
                                <li><a href="/crash/users/fandom/request"><mark class="success">[request new fandom]</mark></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
