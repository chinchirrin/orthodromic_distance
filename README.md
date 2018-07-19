Distance Calculator
===================
Command line tool for calculating distances between two gps coordinates using the Great-circle distance technique.

## Install
In order to get the project ready make sure you have installed composer (package manager) and a modern version of PHP (5.5+).
For setting the project up just run `composer install` at the root dir.

```bash
composer install
```

## Solution
Run command as follows:

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

For more information you can get the help page as follows:

```bash
$ bin/console help intercom:search:customers
```


## Unit Testing
PHPSpec is being used for testing, it is a behaviour driven development (BDD) tool with emphasis in describing objects' behaviour.

For running all the unit tests run the following command:

```bash
$ bin/phpspec run spec/Intercom/ --format=pretty
```

