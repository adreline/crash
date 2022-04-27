<?php  use Crash\Crash as Crash;  ?>
                <div class="window">
                    <h2>Login or join</h2>
                    <div class="content">
                        <?php
                            if(isset($_SESSION['protagonist'])){
                                var_dump($_SESSION['protagonist']);
                            }else{
                                include Crash::$module['users_form'];
                            }
                        ?>

                    </div>
                </div>
                <div class="window">
                    <h2>Newcomers</h2>
                    <div class="content">
                        <?php
                            include_once Crash::$element['user'];
                            use Elements\User as User;
                            foreach(User::getUser(null,"ORDER BY time_stamp DESC LIMIT 5") as $user){
                                echo "<p>><mark class=\"success\">$user->username</mark><br>joined at $user->created_at</p>";
                            }
                         ?>
                    </div>
                </div>
