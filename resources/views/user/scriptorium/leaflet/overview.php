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
                <h2 class="title">You are viewing chapters in <?php echo "\"$publication->title\"" ?></h2>
                  <div class="content">
                  <table>
                    <tr>
                      <th><mark class="info">id</mark></th>
                      <th><mark class="info">actions</mark></th>
                    </tr>
                    <?php
                      foreach($leafs as $leaf){
                            echo "<tr>";
                            echo "<td>$leaf->id</td>";
                            echo "<td><a href=\"/crash/users/scriptorium/leaflet/editor?id_pub=$publication->id&id_leaf=$leaf->id\"><mark class=\"info\">[edit]</mark></a> <a href=\"/crash/users/scriptorium/leaflet/delete?id_pub=$publication->id&id_leaf=$leaf->id\"><mark class=\"danger\">[delete]</mark></a></td>";
                            echo "</tr>";
                      }
                    ?>
                    </table>
                    <a href=<?php echo "\"/crash/users/scriptorium/leaflet/editor?id_pub=$publication->id\""; ?>><mark class="success">[new chapter]</mark></a>
                  </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
