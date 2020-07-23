<?php

use AmitKD\LaravelTaggify\Scopes\TaggifyScopes;

class TagStub extends Illuminate\Database\Eloquent\Model
{
    use TaggifyScopes;

    protected $connection = 'testbench';

    public $table = 'tags';
}
