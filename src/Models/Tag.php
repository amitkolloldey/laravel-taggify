<?php

namespace AmitKD\LaravelTaggify\Models;

use AmitKD\LaravelTaggify\Scopes\TagScopes;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use TagScopes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'count'
    ];


    /**
     * Inverse Polymorphic Between Tag and A Model
     *
     * @param $class
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function items($class)
    {
        return $this
            ->morphedByMany($class,'taggable');
    }
}
