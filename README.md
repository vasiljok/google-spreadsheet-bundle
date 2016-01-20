# WkGoogleSpreadsheetBundle

The WkGoogleSpreadsheetBundle provides a Symfony2 service to interact with the Google Spreadsheet API using the [asimlqt/php-google-spreadsheet-client](https://github.com/asimlqt/php-google-spreadsheet-client) library.
It incorporates the [google/apiclient](https://github.com/google/google-api-php-client) to connect to Google via OAuth2 as a server to server application.

Installation
----------------------------------------------------------------

Require the bundle and its dependencies with composer:

    $ composer require asgoodasnu/google-spreadsheet-bundle
    
Register the bundle:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        new Wk\GoogleSpreadsheetBundle\WkGoogleSpreadsheetBundle(),
    );
}
```

Overwrite the path to your Google OAuth2 JSON credentials defined in `Wk\GoogleSpreadsheetBundle\App\parameters.yml` in your own project's parameter.yml:

```yaml
# parameters.yml

credentials_json_file: /path/to/credentials.json
```
 
Providing your Google OAuth2 credentials
----------------------------------------------------------------
To interact with the Google Spreadsheet API you need to provide your Google OAuth2 service account credentials in JSON format. Please head over to [https://developers.google.com/identity/protocols/OAuth2ServiceAccount](https://developers.google.com/identity/protocols/OAuth2ServiceAccount) for more information on how to create a service account and obtain your service account key.

Usage
----------------------------------------------------------------
The service `wk_google_spreadsheet` provides direct interaction with the Google Spreadsheet PHP Client. You can invoke all methods provided by the client directly on the service:
 
```php
$service = $container->get('wk_google_spreadsheet');

$service->getSpreadsheets();
$service->getSpreadsheetById();
$service->getListFeed();
$service->getCellFeed();
```

See [https://github.com/asimlqt/php-google-spreadsheet-client](https://github.com/asimlqt/php-google-spreadsheet-client) for a full documentation of the client and its methods.

Dependencies
----------------------------------------------------------------
* asimlqt/php-google-spreadsheet-client - Google Spreadsheet PHP Client
* google/apiclient - Client library for Google APIs
* symfony/yaml - Symfony Yaml Component
* symfony/framework-bundle - Symfony FrameworkBundle

PHPunit Tests
----------------------------------------------------------------
    $ vendor/bin/phpunit

Resources
----------------------------------------------------------------
Symfony 2
> [http://symfony.com](http://symfony.com)

Google Spreadsheet PHP Client
> [https://github.com/asimlqt/php-google-spreadsheet-client](https://github.com/asimlqt/php-google-spreadsheet-client)

Google Sheets API (formerly called the Google Spreadsheets API)
> [https://developers.google.com/google-apps/spreadsheets](https://developers.google.com/google-apps/spreadsheets)

Client library for Google APIs
> [https://github.com/google/google-api-php-client/tree/v1-master](https://github.com/google/google-api-php-client/tree/v1-master)

Using OAuth2 service accounts for Server to Server Applications
> [https://developers.google.com/identity/protocols/OAuth2ServiceAccount](https://developers.google.com/identity/protocols/OAuth2ServiceAccount)