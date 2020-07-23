<?php

use AmitKD\LaravelTaggify\Models\Tag;
use Illuminate\Support\Facades\DB;

if (!function_exists('popular_tags_by_model')){

    /**
     * Gets Popular Tags In A Specific Model
     *
     * @param $class
     * @param int $count
     * @return \Illuminate\Support\Collection
     */
    function popular_tags_by_model(string $class, int $count = -1)
    {
        $table = app($class)->getTable();

        return DB::table('taggables')
            ->join(
                'tags',
                'tags.id', '=', 'tag_id'
            )
            ->leftJoin(
                $table,
                $table . '.id', '=', 'taggable_id'
            )
            ->where(
                'taggable_type',
                $class
            )
            ->select(
                DB::raw('count(tag_id) as post_count'),
                'tag_id',
                'tags.name as tag_name'
            )
            ->groupBy(
                'tag_id',
                'tag_name'
            )
            ->orderBy(
                'post_count',
                'desc'
            )
            ->take(
                $count
            )
            ->get();
    }
}


if (!function_exists('popular_tags')){

    /**
     * Gets Popular Tags In All Models
     *
     * @param int $count
     * @return mixed
     */
    function popular_tags(int $count = -1)
    {
        return Tag::orderBy('tags.count','desc')
            ->take($count)
            ->get();
    }
}
