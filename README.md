# symfony mutation example


##Technical Requirements

* Install PHP 7.4 or higher and these PHP extensions (which are installed and enabled by default in most PHP 7 installations): Ctype, iconv, JSON, PCRE, Session, SimpleXML, PCOV and Tokenizer;
* Install Composer, which is used to install PHP packages;
* PHP-Extension:
    * curl
    * json
    * xdebug
* Symfony-CLI (Download): <https://symfony.com/download> for `symfony serve:start`

```
docker-compose up -d

composer install

php bin/console doctrine:database:create --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction

php bin/console doctrine:database:create --env=test --no-interaction
php bin/console doctrine:migrations:migrate --env=test --no-interaction

cp tests/Integration/Service/car.json import
php bin/console car:import

symfony serve:start
```

### CodeCoverage

If you wont to see the code coverage, you can start the test with this script
```
php bin/phpunit --coverage-html coverage 
```
Now you can open the `/coverage/index.html` in browser and see code coverage

### Infection

```
vendor/bin/infection --only-covered 
```

### MySQL-Connect

User: root  
Pass: demo  
Port: 3336

## Install component

#### xDebug

```shell
sudo pecl install xDebug

# example last outupt
#
# Build process completed successfully
# Installing '/usr/lib/php/20190902/xdebug.so'
# install ok: channel://pecl.php.net/xdebug-3.0.3
# configuration option "php_ini" is not set to php.ini location
# You should add "zend_extension=/usr/lib/php/20190902/xdebug.so" to php.ini
```

```
# example for php 7.4 and zend_extension=/usr/lib/php/20190902/xdebug.so

echo "zend_extension=/usr/lib/php/20190902/xdebug.so" | sudo tee -a /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.mode=debug" | sudo tee -a /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.discover_client_host=true" | sudo tee -a /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.start_with_request=yes" | sudo tee -a /etc/php/7.4/mods-available/xdebug.ini

sudo ln -s /etc/php/7.4/mods-available/xdebug.ini /etc/php/7.4/cli/conf.d/20-xdebug.ini
sudo ln -s /etc/php/7.4/mods-available/xdebug.ini /etc/php/7.4/fpm/conf.d/20-xdebug.ini
```


### composer 2

```shell
wget -O composer-setup.php https://getcomposer.org/installer
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```



