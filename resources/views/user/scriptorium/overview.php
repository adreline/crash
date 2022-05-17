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
                <h2 class="title"><?php echo $protagonist->username; ?> works</h2>
                <div class="content">
                    <h4>Published works</h4>
                    <table>
                    <tr>
                      <th><mark class="info">title</mark></th>
                      <th><mark class="info">status</mark></th>
                      <th><mark class="info">published chapters</mark></th>
                      <th><mark class="info">actions</mark></th>
                    </tr>
                    <?php 
                        foreach(E\User::getUserPublications($protagonist->id) as $pub){
                            $published_pages=$pub->getPublicationLeafs($pub->id);
                            $number_of_published_pages=sizeof($published_pages);

                            echo "<tr>";
                            echo "<td>$pub->title</td>";
                            echo "<td>$pub->status</td>";
                            echo "<td>$number_of_published_pages</td>";
                            echo "<td><a href=\"/crash/users/scriptorium/leaflet?id=$pub->id\"><mark class=\"success\">[see chapters]</mark></a> <a href=\"/crash/users/scriptorium/publication/editor?id_pub=$pub->id\"><mark class=\"info\">[edit]</mark></a> <a href=\"/crash/users/scriptorium/publication/delete?id_pub=$pub->id\"><mark class=\"danger\">[delete]</mark></a></td>";
                            echo "</tr>";
                        }
                    ?>

                    </table> 
                    <a href="/crash/users/scriptorium/publication/editor"><mark class="success">[start new work]</mark></a>
                    <a href="/crash/users/fandom/request"><mark class="success">[request new fandom]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">
                
            </div>
        </div>
    </body>
