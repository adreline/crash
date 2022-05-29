# Crash framework #

This is a bare core of Crash, meant to be used as general purpose php framework. For details refer to master repository

### How do I get set up? ###
Pull the repo
```bash
git clone https://adreline@bitbucket.org/adreline/crash.git
```
Create .env file and put it in project root (crash/)
Example of .env:
```php
<?php
    define("DB_CONF",array(
        "host"=>"your_host",
        "database"=>"your_database_name",
        "database_user"=>"your_database_user",
        "database_pass"=>"your_database_password"
    ));
    define("ANCHOR","http://your_host/crash/");
    define("EVIROMENT",ENV_LOOKUP["PRODUCTION"]);
    ?>
```
Migrate the database
```bash
mysql -u your_database_user -p your_database_name < crash/resources/database/migrate.sql
```
#### What now? #####
[Learn how to build on Crash](https://maddie-nie.atlassian.net/l/c/prTPb4iP)





