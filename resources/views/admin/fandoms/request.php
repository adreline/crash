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
                <h2 class="title">Fandom requests</h2>
                <div class="content">
                    <table>
                    <tr>
                      <th><mark class="info">friendly name</mark></th>
                      <th><mark class="info">URI</mark></th>
                      <th><mark class="info">requested at</mark></th>
                      <th><mark class="info">actions</mark></th>
                    </tr>
                    <?php 
                        foreach(E\Fandom::getInactiveFandoms() as $fandom){
                            echo "<tr>";
                            echo "<td>$fandom->friendly_name</td>";
                            echo "<td>$fandom->name</td>";
                            echo "<td>$fandom->created_at</td>";
                            echo "<td><a href=\"/crash/admin/fandoms/accept?id=$fandom->id\"><mark class=\"success\">[accept]</mark></a> <a href=\"/crash/admin/fandoms/deny?id=$fandom->id\"><mark class=\"danger\">[deny]</mark></a> </td>";
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
