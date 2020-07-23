Laravel Taggify
============

[![Latest Stable Version](https://poser.pugx.org/rtconner/laravel-tagging/v/stable.svg)](https://packagist.org/packages/rtconner/laravel-tagging)
[![Total Downloads](https://poser.pugx.org/rtconner/laravel-tagging/downloads.svg)](https://packagist.org/packages/rtconner/laravel-tagging)
[![License](https://poser.pugx.org/rtconner/laravel-tagging/license.svg)](https://packagist.org/packages/rtconner/laravel-tagging)
[![Build Status](https://travis-ci.org/rtconner/laravel-tagging.svg?branch=laravel-7)](https://travis-ci.org/rtconner/laravel-tagging)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rtconner/laravel-tagging/badges/quality-score.png?b=laravel-7)](https://scrutinizer-ci.com/g/rtconner/laravel-tagging/?branch=laravel-7)


This package will allow user to add Tagging system in the Laravel 7 application. 

You can provide combination of string or id or model to create tags. It will check if a tag is already exists in the tags table. If not it will create a new tag and attach with the model. It also comes with some useful helpers and Scopes.

#### Composer Install

```shell
composer require amitkolloldey/laravel-taggify
```

#### Run the migrations

Migrate The database tables 

```bash
php artisan migrate
```

#### Setup your models
```php
<?php

namespace App;

use AmitKD\LaravelTaggify\Taggify;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Taggify;

    protected $fillable = [
        'title'
    ];
}
```
 
#### Credits

 - Amit Kollol Dey - http://amitkolloldey.me
 
