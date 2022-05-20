<?php
    use Crash\Crash as Crash;
    use Elements as E;
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
                <h2 class="title">Admin Panel</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column">
                            <h5>System info</h5>
                            <p>Registered users: <mark class="info"><?php echo $users_count; ?></mark></p>
                            <p>Publications: <mark class="info"><?php echo $works_count; ?></mark></p>
                        </div>
                        <div class="column">

                        </div>
                    </div>
                    <h4>Actions</h4>
                    <a href="/crash/admin/pages"><mark class="success">[manage static pages]</mark></a>
                    <a href="/crash/admin/fandoms"><mark class="success">[view fandom requests]</mark></a>
                    <a href="/crash/admin/users"><mark class="success">[manage users]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
