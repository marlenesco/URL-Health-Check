# README #

### What is this repository for? ###
Php-cli app to check the status code of an URL.

If the status code is 200 the url works; otherwise, the app will send a message to the list of emails.

Any configuration about email account and emails list are placed in `inc/conf.php` file.

### How do I get set up? ###

Clone repository and manage dependencies with composer:

* $ `git clone https://github.com/marlenesco/URL-Health-Check.git`
* $ `composer install`

### How it works? ###

It works via Command Line Interface (php-cli), exec the following command:

`php index.php -uhttps://www.google.com`

### Crontab ###

Setting up a crontab:

$ `crontab -e`

In crontab editor insert the following line:

`*/5 * * * * /usr/local/bin/php /{Application-Path}/index.php -u{URL-TO-CHECK}`

* Check your php installation directory (/usr/local/bin/php in above case).
* Replace `{Application-Path}` with your application installation directory.
* Replace `{URL-TO-CHECK}` with a valid URL to check.

You can check more URLs in your crontab job:

`*/5 * * * * /usr/local/bin/php /{Application-Path}/index.php -u{URL-TO-CHECK}`

`*/5 * * * * /usr/local/bin/php /{Application-Path}/index.php -u{ANOTHER-URL-TO-CHECK}`

In this case, `*/5 * * * *` every 5 minutes meaning.

You can see more information about "how to generate the Crontab command" in [Crontab Generator](https://crontab-generator.org/) page.
