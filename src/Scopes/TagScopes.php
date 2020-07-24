<?php

namespace AmitKD\LaravelTaggify\Scopes;

trait TagScopes
{
    /**
     * Gets Most Popular Tags
     *
     * @param $query
     * @param int $count
     * @return mixed
     */
    public function scopePopular($query, int $count = -1)
    {
        return $query
            ->orderBy('count', 'desc')
            ->take($count);
    }

    /**
     * Gets Less Used Tags By Tag Count
     *
     * @param $query
     * @param int $count
     * @return mixed
     */
    public function scopeUnpopular($query, int $count = -1)
    {
        return $query
            ->orderBy('count', 'asc')
            ->take($count);
    }

    /**
     * Gets Unused Tags
     *
     * @param $query
     * @param int $count
     * @return mixed
     */
    public function scopeUnUsed($query, int $count = -1)
    {
        return $query
            ->orderBy('count', 'asc')
            ->take($count);
    }

    /**
     * Gets The Tags Being Used More Than Given Times
     *
     * @param $query
     * @param $count
     * @return mixed
     */
    public function scopeUsedMoreThan($query, $count = -1)
    {
        return $query
            ->where('count', '>', $count);
    }

    /**
     * Gets The Tags Being Used Less Than Given Times
     *
     * @param $query
     * @param $count
     * @return mixed
     */
    public function scopeUsedLessThan($query, $count = -1)
    {
        return $query
            ->where('count', '<', $count);
    }
}