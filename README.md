HoneyDB
=======

Database and web interface for HoneyPy honeypot logs. Example, http://www.foospidy.com/opt/honeydb/


Getting started:

1. Assumption is you know the basics of how to setup an Linux|Apache|MySQL|PHP (LAMP) web app.

2. Install dependencies with composer (https://getcomposer.org/). Once you have composer setup, run: "composer install" in HoneyDb's web root directory. The web root directory contains "composer.json", which will be used by the composer command.

3. Download latest Geo IP database from http://dev.maxmind.com/geoip/geoip2/geolite2/. Make sure you get the "GeoLite2 City" .mmdb file. Copy it to HoneyDB's usr/data/ directory.

4. Create database. Suggested database name is "honeydb" but you can name whatever you like. Once you've created your database use the create.sql script to create the database table. Example command line:
`mysql -u <db username> -p <db name> < create.sql`

5. Configure HoneyDB by editing the constants section of the `etc/configuration.php` file:
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

6 Edit .htaccess file. Make sure the RewriteBase is set to the same value as $WEBROOT in index.php

Getting log data:

There are two methods of getting log data from HoneyPy. First you can enable the `[honeypysql]` option in the `honeypy.cfg` file (https://github.com/foospidy/HoneyPy/blob/master/etc/honeypy.cfg). This option generates `.sql` files that can then be used to import the data directly into the database. Second, you can enable the `[honeydb]` option in the `honeypy.cfg` file. The `url` parameter should be pointed at: `https://<your server>/honeydb/logger`. And the secret parameter should be a long random value to mitigate unauthorized posts, or attacks, against HoneyDB.

NOTE: Originally service names were wrapped in brackets, e.g. [telnet]. Now HoneyDB expects the service name without brackets. The logger will strip the brackets if they are present. If you have service names with brackets in your database you will need to run the following sql commands:
`update honeypy set service=REPLACE(service, '[', '');`
`update honeypy set service=REPLACE(service, ']', '');`
