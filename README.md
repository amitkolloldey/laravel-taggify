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
It will migrate `tags` , `taggables` tables

#### Setup your models
To creat a many to many polymorphic relation with your model and tags you need to use the `Taggify` trait.
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
#### Usage
To attach/create new tags it uses addTags method. This method takes an array containing models or id or name of the tags you want to attach to your model and of course you can all use combination of these.

#### Attaching or Creating tags

```php
<?php

 $post = \App\Post::findOrFail(2);
 $post->addTags( [ 'Non Existing Tag', 'Spring Framework', 'Java']);

```
Or
 ```php
<?php
 
  $post = \App\Post::findOrFail(2);
  $tag = Tag::findOrFail(7);
  $post->addTags( [ $tag, 8, 9, 'Java']); // Tag model/ids/name
 
 ```
The name will generate a unique slug for the tag and will increment the `count` column. The `count` column will represent how many times the tag's being used.

 #### Detaching given tags
 
 ```php
<?php
 
  $post = \App\Post::findOrFail(2); 
  $tag = Tag::findOrFail(7);
  $post->removeTags([ $tag, 8, 9, 'Java']);
 
 ```
The remove tags will detach the given tags and decrement the `count` column.

 #### Detaching all tags
 
 ```php
<?php
 
  $post = \App\Post::findOrFail(2); 
  $post->removeAllTags();
 
 ```
It will detach all the tags associated with the model and decrement the `count` column.

 #### Re tag
 
 ```php
<?php
 
  $post = \App\Post::findOrFail(2); 
  $post->reTag(['Python','PHP','php oop']);
 
 ```
It will detach Previous Tags and attach Given Tags and decrement the `count` column.

#### Scopes
 
##### withAnyTag

 ```php
<?php
 
  $posts = Post::withAnyTag(['Laravel','Java', 9])->get()->dd();
   
 ```
 Gets The Models Associated with Any Given Tags.


##### withAllTags

 ```php
<?php
 
  $posts = Post::withAllTags(['Laravel','Java', 9])->get()->dd();
   
 ```
 Finds The Models Where Given All Tags Are In Common.
 
##### popular
 
  ```php
<?php

   Tag::popular(5)->get()->dd(); // 5 is how many tags to display
    
  ```
  It will give the most popular tags based on `count` column.
 
##### unPopular
  
   ```php
<?php
 
    Tag::unPopular(5)->get()->dd(); // 5 is how many tags to display
     
   ```
   Gets Less Used Tags based on `count` column.
   
##### unUsed
     
  ```php
<?php

   Tag::unUsed(5)->get()->dd(); // 5 is how many tags to display
    
  ```
Gets Unused Tags based on `count` column.

##### usedMoreThan
     
  ```php
<?php

   Tag::usedMoreThan(5)->take(5)->get()->dd(); ; // more then 5 times tag's being used
    
  ```
Return tags that are used more than given times based on `count` column.  

##### usedLessThan
     
  ```php
<?php

   Tag::usedLessThan(5)->take(5)->get()->dd(); // not more then 5 times tag's being used
    
  ```
Return tags that are used less than given times based on `count` column.  

#### Helpers
The package comes with 2 useful helpers, which you can use throughout your application.

##### popular_tags_by_model

  ```blade
    <ul>
       @foreach (popular_tags_by_model("App\Post") as $popular_tag)
        <!-- Model class, number of items to take --> 
            <li>
                <p>{{$popular_tag->tag_id}}</p>
                <p>{{$popular_tag->tag_name}}</p>
                <p>{{$popular_tag->tag_slug}}</p>
                <p>{{$popular_tag->model_count}}</p>
                <p>{{$popular_tag->tag_description}}</p> 
            </li>
       @endforeach
    </ul>
    
  ```
Gets Popular Tags In A Specific Model. 

##### popular_tags

  ```blade
    <ul>
       @foreach (popular_tags(5) as $popular_tag) 
            <!-- number of items to take --> 
            <li>
                <p>{{$popular_tag->id}}</p>
                <p>{{$popular_tag->slug}}</p>
                <p>{{$popular_tag->name}}</p>
                <p>{{$popular_tag->count}}</p>
                <p>{{$popular_tag->description}}</p> 
            </li>
       @endforeach
    </ul>
    
  ```
Gets Popular Tags In All Models 

#### Inverse Relation in Tag Model

use items() method and give a model 

  ```php
<?php

   $tag = Tag::findOrFail(7);
   $tag = $tag->items(Post::class)->take(5)->get()->dd();
    
  ```
Inverse Polymorphic Between Tag and A Model. 

**You can also add inverse relationship by extending the `AmitKD\LaravelTaggify\Models\Tag` model**

#### Credits

 - Amit Kollol Dey - http://amitkolloldey.me
 
