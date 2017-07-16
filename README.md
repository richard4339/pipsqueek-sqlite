# Pipsqueek SQLite

[![Latest Stable Version](https://poser.pugx.org/richard4339/pipsqueek-sqlite/v/stable)](https://packagist.org/packages/richard4339/pipsqueek-sqlite)
[![Total Downloads](https://poser.pugx.org/richard4339/pipsqueek-sqlite/downloads)](https://packagist.org/packages/richard4339/pipsqueek-sqlite)
[![Latest Unstable Version](https://poser.pugx.org/richard4339/pipsqueek-sqlite/v/unstable)](https://packagist.org/packages/richard4339/pipsqueek-sqlite)
[![License](https://poser.pugx.org/richard4339/pipsqueek-sqlite/license)](https://packagist.org/packages/richard4339/pipsqueek-sqlite)
[![composer.lock](https://poser.pugx.org/richard4339/pipsqueek-sqlite/composerlock)](https://packagist.org/packages/richard4339/pipsqueek-sqlite)
[![Build Status](https://travis-ci.org/richard4339/pipsqueek-sqlite.svg?branch=master)](https://travis-ci.org/richard4339/pipsqueek-sqlite)

SQLite addon for [Medoo](https://medoo.in) with constructor, meant for the PipSqueek Bot but usable anywhere

## Install via composer

```
$ composer require richard4339/pipsqueek-sqlite
```

## Usage

```php
use Pipsqueek\DB\SQLite\DB;
  
require 'vendor/autoload.php';
  
// Initialize
$db = new DB([
    'database_type' => 'sqlite',
    'database_file' => DBPATH
]);
  
$where["chatid"] = 12345;
  
$results = $db->getRandom(SOMETABLE, ["column1", "column2"], $where);
```

See more specifics on [Medoo](https://medoo.in) itself on their [Readme](https://github.com/catfan/Medoo/blob/master/README.md#get-started) or their [website](https://medoo.in)

## Links

* [Medoo website](https://medoo.in)

* [PipSqueek IRC Bot](https://github.com/mozor/pipsqueek)