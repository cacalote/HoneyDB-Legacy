HoneyDB
=======

Database and web interface for HoneyPy honeypot logs


Getting started:

1. Assumption is you know the basics of how to setup an Linux|Apache|MySQL|PHP (LAMP) web app.

2. Install dependencies with composer (https://getcomposer.org/). Once you have composer setup, run: "composer install" in HoneyDb's web root directory. The web root directory contains "composer.json", which will be used by the composer command.

3. Download latest Geo IP database from http://dev.maxmind.com/geoip/geoip2/geolite2/. Make sure you get the "GeoLite2 City" .mmdb file. Copy it to HoneyDB's usr/data/ directory.

4. Create database. Suggested database name is "honeydb" but you can name whatever you like. Once you've created your database use the create.sql script to create the database table. Example command line:
mysql -u <db username> -p <db name> < create.sql

5. Configure HoneyDB by editing the constants section of the index.php file:
```php
// constants
$WEBROOT        = ''; // the root path for the web site starting at "/"
$SHODAN_API_KEY = ''; // if you have a shodan api key
$LOGGER_ENABLE  = 'No'; // set to Yes if your HoneyPy honeypot is configured to post logs to the web logger.
$LOGGER_SECRET  = ''; // suggestion, generate secret from https://www.grc.com/passwords.htm
$LOGGER_FILTER  = ''; // optional, comma delimated ip address list.
$DB_HOST        = ''; // your mysql database host, typically "localhost"
$DB_NAME        = ''; // the name of the database you created.
$DB_USER        = ''; // the database user you created.
$DB_PASS        = ''; // the password for the database user.

```


6. Edit .htaccess file. Make sure the RewriteBase is set to the same value as $WEBROOT in index.php

Getting log data:

todo :)
