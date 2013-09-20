zDbSession
==========

ZF2 module for saving sessions to database using doctrine entities, this module will deprecate my previous db session module

Installation
============
  1. Run `php composer.phar require nitecon/zdbsession:dev-master`
  2. Add `zDbSession` to the enabled modules list
  3. Copy `./vendor/nitecon/zdbsession/config/zDbSession.local.php.dist` => `./config/autoload/zDbSession.local.php`
  4. Make sure to import the schema before setting `enabled` to `\TRUE` in `./config/autoload/zDbSession.local.php`
  5. Set `'enabled' => \TRUE,` in ./config/autoload/zDbSession.local.php
  6. Configure your session options & doctrine entity cache manager in `./config/autoload/zDbSession.local.php`
  7. Enjoy!
