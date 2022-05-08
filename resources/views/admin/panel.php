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
                <h2>Admin Panel</h2>
                <div class="content">
                    <div class="columns">
                        <div class="column">
                            <h5>System info</h5>
                            <p>DB Size: <mark class="info">22MB</mark></p>
                            <p>Registered users: <mark class="info">33</mark></p>
                            <p>Publications: <mark class="info">342</mark></p>
                        </div>
                        <div class="column">
                            <h5>System events</h5>
                            <p>balh vbah</p>
                        </div>
                    </div>
                    <h5>Tasks</h5>
                    <a href="/crash/admin/pages">><mark class="success">Manage static pages</mark></a>
                    <p>><mark class="success">Manage users</mark></p>
                    <p>><mark class="success">Manage system settings</mark></p>
                    <p>><mark class="success">Manage templates</mark></p>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
