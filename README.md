Laravel Taggify - Eloquent Tagging Package
============

[![Latest Stable Version](https://poser.pugx.org/amitkolloldey/laravel-taggify/v)](//packagist.org/packages/amitkolloldey/laravel-taggify) [![Total Downloads](https://poser.pugx.org/amitkolloldey/laravel-taggify/downloads)](//packagist.org/packages/amitkolloldey/laravel-taggify) [![Latest Unstable Version](https://poser.pugx.org/amitkolloldey/laravel-taggify/v/unstable)](//packagist.org/packages/amitkolloldey/laravel-taggify) [![License](https://poser.pugx.org/amitkolloldey/laravel-taggify/license)](//packagist.org/packages/amitkolloldey/laravel-taggify)


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
 
