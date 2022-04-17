# Crash #

Crash is a online content management system (CMS), made in pure PHP and designed to be as small as possible. It specialises in publishing written transformative works. 

### What is this repository for? ###

For SunriseSystem internal evaluation.

* [Documentation](https://maddie-nie.atlassian.net/wiki/spaces/CF/overview)
* [Live demo](http://niecko.4suns.pl/crash/)

### How do I get set up? ###
Pull the repo
```bash
git clone https://adreline@bitbucket.org/adreline/crash.git
```
Create .env file, example:
```php
<?php
    define("DB_CONF",array(
        "host"=>"your_host",
        "database"=>"your_database_name",
        "database_user"=>"your_database_user",
        "database_pass"=>"your_database_password"
    ));
    ?>
```
Migrate the database
```bash
mysql -u your_database_user -p your_database_name < crash/resources/database/migrate.sql
```
You may want to populate database with mock data. To do that, navigate to /your/host/crash/resources/database/factory.php


