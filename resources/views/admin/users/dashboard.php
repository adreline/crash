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
                <h2 class="title">Manage users</h2>
                <div class="content">
                    <table>
                    <tr>
                      <th><mark class="info">username</mark></th>
                      <th><mark class="info">active</mark></th>
                      <th><mark class="info">administrator</mark></th>
                      <th><mark class="info">created at</mark></th>
                      <th><mark class="info">updated at</mark></th>
                      <th><mark class="info">actions</mark></th>
                    </tr>
                    <?php 
                        foreach(E\User::getUser() as $user){
                            $admin = ($user->administrator) ? "<mark class=\"info\">yes</mark>" : "<mark class=\"success\">no</mark>";
                            $active = ($user->active) ? "<mark class=\"success\">active</mark>" : "<mark class=\"danger\">disabled</mark>";
                            echo "<tr>";
                            echo "<td>$user->username</td>";
                            echo "<td>$active</td>";
                            echo "<td>$admin</td>";
                            echo "<td>$user->created_at</td>";
                            echo "<td>$user->updated_at</td>";
                            echo "<td>";
                            echo ($user->active) ? "<a href=\"/crash/admin/users/disable?id_user=$user->id\"><mark class=\"danger\">[ban]</mark></a>" : "<a href=\"/crash/admin/users/enable?id_user=$user->id\"><mark class=\"success\">[unban]</mark></a>";
                            echo ($user->administrator) ? "<a href=\"/crash/admin/users/demote?id_user=$user->id\"><mark class=\"danger\">[demote]</mark></a>" : "<a href=\"/crash/admin/users/elevate?id_user=$user->id\"><mark class=\"info\">[promote]</mark></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>

                    </table> 
                </div>
                </div>
            </div>
            <div class="column is-1-4">
                
            </div>
        </div>
    </body>
