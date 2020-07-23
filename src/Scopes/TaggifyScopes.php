<?php

namespace AmitKD\LaravelTaggify\Scopes;

trait TaggifyScopes
{
    /**
     * Gets The Models Associated with Any Given Tags
     *
     * @param $query
     * @param $tags
     * @return mixed
     */
    public function scopeWithAnyTag($query, $tags)
    {
        $tags = $this
            ->tagCollection($tags);

        return $query
            ->whereHas(
                'tags',
                function ($query) use ($tags) {
                    $query
                        ->whereIn('tags.id', $tags);
                }
            );
    }

    /**
     * Finds The Models Where Given All Tags Are In Common
     *
     * @param $query
     * @param $tags
     * @return mixed
     */
    public function scopeWithAllTags($query, array $tags)
    {
        $tags = $this
            ->tagIds($tags);

        foreach ($tags as $tag) {
            $query
                ->whereHas(
                    'tags',
                    function ($query) use ($tag) {
                        $query
                            ->where('tags.id', $tag);
                    }
                );
        }

        return $query;
    }
}