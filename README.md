# [Magefan](http://magefan.com/) Rocket JavaScript Extension for Magento 2

Move all javascripts to the footer.

## Features
  * Rocket JavaScript module allows you to move all javascript tags to the footer of the storefront page on your [Magento 2](http://magento.com/) Store.

## Configuration
  * To enable or disable extension please navigate to Magento 2 Admin Panel > Stores > Magefan Extensions > Rocket JavaScript

## Requirements
  * Magento Community Edition 2.1.x or Magento Enterprise Edition 2.1.x

## Installation Method 1 - Installing via composer
  * Open command line
  * Using command "cd" navigate to your magento2 root directory
  * Run command: composer require magefan/module-rocketjavascript


## Installation Method 2 - Installing using archive
  * Download [ZIP Archive](https://github.com/magefan/module-rocketjavascript/archive/master.zip)
  * Extract files
  * In your Magento 2 root directory create folder app/code/Magefan/Blog
  * Copy files and folders from archive to that folder
  * In command line, using "cd", navigate to your Magento 2 root directory
  * Run commands:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Support
If you have any issues, please [contact us](mailto:support@magefan.com)
then if you still need help, open a bug report in GitHub's
[issue tracker](https://github.com/magefan/module-rocketjavascript/issues).

Please do not use Magento Marketplace's Reviews or (especially) the Q&A for support.
There isn't a way for us to reply to reviews and the Q&A moderation is very slow.

## Donate to us
All Magefan extension are absolutely free and licensed under the Open Software License version 3.0. We want to create more awesome features for you and bring up new releases as fast as we can. We hope for your support.
http://magefan.com/donate/

## License
The code is licensed under [Open Software License ("OSL") v. 3.0](http://opensource.org/licenses/osl-3.0.php).
