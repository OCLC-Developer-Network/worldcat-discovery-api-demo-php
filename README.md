# Worldcat Discovery Sample App

An App that demonstrates using WorldCat Discovery to build a search interface. There are currently no tests for this app. Tests will be added over the next few weeks.

## Installation

### Step 1: Install from GitHub

In a Terminal Window

```bash
$ cd {YOUR-APACHE-DOCUMENT-ROOT}
$ git clone https://github.com/OCLC-Developer-Network/worldcat-discovery-api-demo-php.git
$ cd worldcat-discovery-api-demo-php
```

### Step 2: Use composer to install the dependencies

```bash
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install
```

[Composer](https://getcomposer.org/doc/00-intro.md) is a dependency management library for PHP. It is used to install the required libraries for testing and parsing RDF data. The dependencies are configured in the file `composer.json`.

### Step 3: Configure your environment file with your WSKey/secret and other info

```bash
$ vi .env.php
```
Sample Environment File
```php
<?php

return array(

    'wskey' => 'your-key',
    'secret' => 'your-secret'
);
```
### Step 4: Configure the application
Edit the /app/config/app.php file

institutionID - your institution WorldCat RegistryID
heldBy - array that includes your OCLC Symbol

Optionally enable
showAvailability
showEHoldings
showReccomendations
showDbpediaInfo
showIdentitiesInfo
debugAPIcalls

## Usage

To run the app, point your web browser at the localhost address where these instructions will install it by default. 

[http://localhost/worldcat-discovery-api-demo-php/public/](http://localhost/worldcat-discovery-api-demo-php/public/)
