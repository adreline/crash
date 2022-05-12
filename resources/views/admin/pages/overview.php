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
                <h2 class="title">Manage pages</h2>
                <div class="content">
                    <h5>Existing pages</h5>
                    <table>
                    <tr>
                      <th><mark class="info">title</mark></th>
                      <th><mark class="info">url</mark></th>
                      <th><mark class="info">actions</mark></th>
                    </tr>
                    <?php 
                        foreach($pages as $page){
                            echo "<tr>";
                            echo "<td>$page->friendly_name</td>";
                            echo "<td>/crash/$page->name</td>";
                            echo "<td><a href=\"/crash/admin/pages/edit?id=$page->id\"><mark class=\"info\">[edit]</mark></a> <a href=\"/crash/admin/pages/delete?id=$page->id\"><mark class=\"danger\">[delete]</mark></a></td>";
                            echo "</tr>";
                        }
                    ?>
                    </table> 
                    <a href="/crash/admin/pages/new"><mark class="success">[new page]</mark></a>
                </div>
                </div>
            </div>
            <div class="column is-1-4">

            </div>
        </div>
    </body>
