# Worldcat Discovery Sample App

An App that demonstrates using WorldCat Discovery to build a search interface

## Installation

### Step 1: Install from GitHub

In a Terminal Window

```bash
$ cd {YOUR-APACHE-DOCUMENT-ROOT}
$ git clone https://github.com/OCLC-Developer-Network/worldcat-discovery-api-demo.git
$ cd worldcat-discovery-api-demo
```

### Step 2: Use composer to install the dependencies

```bash
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install
```

[Composer](https://getcomposer.org/doc/00-intro.md) is a dependency management library for PHP. It is used to install the required libraries for testing and parsing RDF data. The dependencies are configured in the file `composer.json`.

## Usage

To run the app, point your web browser at the localhost address where these instructions will install it by default. 

[http://localhost/worldcat-discovery-api-demo/](http://localhost/worldcat-discovery-api-demo/)

Modify the file `app/config/config.yaml` to use your WSKey and secret.

## Running the tests

The tests primarily use local files (`tests/mocks`) to perform testing. 
In a terminal window:

```bash
$ cd tests/
$ ../vendor/bin/phpunit
```