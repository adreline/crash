            <?php  use Crash\Crash as Crash;  ?>
            <div class="is-hidden-mobile">
                <?php
                //display either user banner or login form
                    if(isset($_SESSION['protagonist'])){
                        include Crash::$module['user_banner'];
                    }else{
                        include Crash::$module['users_form'];
                    }
                ?>
                <div class="window">
                    <h2 class="title">Newcomers</h2>
                    <div class="content">
                        <?php
                            include_once Crash::$element['user'];
                            use Elements\User as User;
                            foreach(User::getActiveUsers("ORDER BY created_at DESC LIMIT 5") as $user){
                                echo "<p>><mark class=\"success\">$user->username</mark><br>joined at $user->created_at</p>";
                            }
                         ?>
                    </div>
                </div>
            </div>