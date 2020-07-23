<?php

use AmitKD\LaravelTaggify\Taggify;

class PostStub extends Illuminate\Database\Eloquent\Model
{
    use Taggify;

    protected $connection = 'testbench';

    public $table = 'posts';

}
