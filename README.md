Distance Calculator
===================

A console command component that allows you to filter records based on the distance to a given GPS coordinates (location).
The Great-circle distance technique is used for calculating distances between two given GPS coordinates.

## Install
In order to get the project ready make sure you have compose installed and a modern version of PHP5+.
For setting the project up just run `composer install` at the root dir.

```bash
composer install
```

## Solution
Based on Symfony console component, just run it as follows:

```bash
$ bin/console  intercom:search:customers
Customers within 100 Km radius:
UserId: 4; Name: Ian Kehoe
UserId: 5; Name: Nora Dempsey
UserId: 6; Name: Theresa Enright
UserId: 8; Name: Eoin Ahearn
UserId: 11; Name: Richard Finnegan
...
```

Optionally the `--radius=VALUE` parameter can be passed to use a different distance other than the default of 100 km.

For more information you can get the help page as follows:

```bash
$ bin/console help intercom:search:customers
```


## Unit Testing
PHPSpec is being used for testing, it is a behaviour driven development (BDD) toolwith emphasis in describing objects behaviour.

For running all the unit tests run the following command:

```bash
$ bin/phpspec run spec/Intercom/ --format=pretty
```

