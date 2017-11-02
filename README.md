# DataBaseManager

The goal of this library is to simplify the use of PDO. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

My library need 
PHP 7.0

And work with 
- MySql
- SqLite

### Installing

You can install this library via the composer command

```
composer require 2latlantik/data-base-manager
```

### Use

First, you must specify the parameters connection via an array which sepcify
``` json   
$params = [
    'dsn'       => 'mysql',   
    'dbname'    => 'test',
    'host'      => 'localhost',
    'username'  => 'root',
    'password'  => '',
]
```


It's necessary to get a new connection to a database via these commands

````
$config = new \App\DataBase\Config($params);
$pdo = \App\DataBase\MyPDO::getConnection('mysql', $config);
````
## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
