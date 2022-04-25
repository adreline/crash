                <div class="window">
                    <h2>Login or join</h2>
                    <div class="content">
                        <form action="users/enlist" method="post">
                        <a>crash@login:~$ <input type="text" name="username"></a>
                        <a>crash@password:~$ <input type="password" name="password"></a>
                        <button type="submit" name="login"><mark class="success">>login</mark></button>
                        <button type="submit" name="register"><mark class="info">>register</mark></button>
                        </form>
                    </div>
                </div>
                <div class="window">
                    <h2>Newcomers</h2>
                    <div class="content">
                        <?php
                            include_once Crash::$element['user'];
                            foreach(User::getUser(null,"ORDER BY time_stamp DESC LIMIT 5") as $user){
                                echo "<p>><mark class=\"success\">$user->username</mark><br>joined at $user->created_at</p>";
                            }
                         ?>
                    </div>
                </div>
