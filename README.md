zDbSession
==========

ZF2 module for saving sessions to database using doctrine entities, this module will deprecate my previous db session module

Pre-Install Notice
==================
Please note that this module assumes that you already use doctrine orm module in your application if you are not
currently using it then you can still use this module by configuring it.  Due to the requirements in composer.json
it should auto install DoctrineModule and DoctrineORMModule for you.  But you will still need to configure it.

To do this:
  1. Add `DoctrineModule` and `DoctrineORMModule` to your `./config/application.config.php`
  2. Add the following code snippet to your `./config/autoload/local.php`
<pre>'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'yourdbuser',
                    'password' => 'yourpassword',
                    'dbname' => 'yourdbname'
                )
            )
        ),
  ),</pre>

Please Note
===========
The above code snippet is just an example for MySQL using the PDO driver.  You will still need to alter it to match your database

Installation
============
  1. Run `php composer.phar require nitecon/zdbsession:dev-master`
  2. Add `zDbSession` to the enabled modules list
  3. Copy `./vendor/nitecon/zdbsession/config/zDbSession.local.php.dist` => `./config/autoload/zDbSession.local.php`
  4. Make sure to import the schema before setting `enabled` to `\TRUE` in `./config/autoload/zDbSession.local.php`
  5. Set `'enabled' => \TRUE,` in ./config/autoload/zDbSession.local.php
  6. Configure your session options & doctrine entity cache manager in `./config/autoload/zDbSession.local.php`
  7. Enjoy & Help support by submitting issues & bug fixes!
