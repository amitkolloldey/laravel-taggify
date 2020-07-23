<?php

namespace AmitKD\LaravelTaggify;

use AmitKD\LaravelTaggify\Models\Tag;
use AmitKD\LaravelTaggify\Scopes\TaggifyScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

/**
 * Trait Taggify
 * @package AmitKD\LaravelTaggify
 */
trait Taggify
{
    use TaggifyScopes;

    /**
     * Removes Previous Tags and Add Given Tags
     *
     * @param mixed $tags
     * @return array
     */
    public function reTag($tags): array
    {
        $this
            ->removeAllTags();

        return $this
            ->addTags($tags);
    }

    /**
     * Removes All Tags
     *
     * @return int
     */
    public function removeAllTags(): int
    {
        $this
            ->decrementTagCount(
                $this
                    ->tags()
                    ->pluck('tags.id')
                    ->toArray()
            );
        return $this
            ->tags()
            ->detach();
    }

    /**
     * Decrements The Tag Count
     *
     * @param $detached
     */
    private function decrementTagCount(array $detached): void
    {
        $this
            ->tags()
            ->where('count', '>', 0)
            ->whereIn('tags.id', $detached)
            ->decrement('count');
    }

    /**
     * Get all of the tags for the model.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Add Tags To A Model
     *
     * @param $tags
     * @return array
     */
    public function addTags(array $tags): array
    {
        $sync_tags = $this
            ->tags()
            ->syncWithoutDetaching(
                $this
                    ->tagCollection($tags)
            );

        $this
            ->incrementTagCount(
                $sync_tags['attached']
            );

        return $sync_tags;
    }

    /**
     * Converts Given Tags into Collection
     *
     * @param array $tags
     * @return array
     */
    private function tagCollection(array $tags): array
    {
        $tagList = $this
            ->tagList();

        $tags = array_map(function ($tag) use ($tagList) {

            // If This Is An ID
            if (is_int($tag)) {
                if (in_array($tag, $tagList['tag_id_list'])) {
                    return $tag;
                }
            }

            // If This Is A Name
            if (is_string($tag)) {
                $un_slugged_tag = $tag;
                $tag_id = array_search($un_slugged_tag, $tagList['tag_name_list']);
                if ($tag_id) {
                    return $tag_id;
                } else {
                    return $this
                        ->createNewTag($un_slugged_tag);
                }
            }

            // If This Is A Tag Model
            if ($tag instanceof Model) {
                return $tag->id;
            }

            return null;

        }, $tags);

        // Removes Null Value From The Array
        return array_unique(array_filter($tags));
    }

    /**
     * @return array
     */
    private function tagList()
    {
        $tag_id_list = $tag_name_list = [];

        $all_tags = Tag::get([
            'id',
            'slug',
            'name'
        ])
            ->toArray();

        foreach ($all_tags as $tag) {
            $tag_id_list[] = $tag['id'];
            $tag_name_list[$tag['id']] = $tag['name'];
        }

        return [
            'tag_id_list' => $tag_id_list,
            'tag_name_list' => $tag_name_list,
        ];
    }

    /**
     * Creates Non Existing Tag
     *
     * @param string $un_slugged_tag
     * @return int
     */
    private function createNewTag(string $un_slugged_tag): int
    {
        $tag = Tag::create([
            'name' => $un_slugged_tag,
            'slug' => $this->sluggifyTag($un_slugged_tag),
            'count' => 0
        ]);

        return $tag->id;
    }

    /**
     * Converts Tag into Unique Slug if needed
     *
     * @param string $tag
     * @return string
     */
    private function sluggifyTag(string $tag): string
    {
        $slugged = Str::slug($tag);
        if ($this->getSlugCount($slugged)) {
            $count = 1;
            $new_slug = $slugged . '-' . $count;
            while ($this->getSlugCount($new_slug)) {
                $count++;
                $new_slug = $slugged . '-' . $count;
            }
            $slugged = $new_slug;
        }
        return $slugged;
    }

    /**
     * @param string $new_slug
     * @return mixed
     */
    private function getSlugCount(string $new_slug)
    {
        return Tag::where('slug', $new_slug)->count();
    }

    /**
     * Increments The Tag Count
     *
     * @param array $attached
     */
    private function incrementTagCount(array $attached): void
    {
        $this
            ->tags()
            ->whereIn('tags.id', $attached)
            ->increment('count');
    }

    /**
     * Removes Given Tags
     *
     * @param array $tags
     * @return int
     */
    public function removeTags(array $tags): int
    {
        $this
            ->decrementTagCount(
                $this
                    ->tagCollection($tags)
            );

        return $this
            ->tags()
            ->detach(
                $this
                    ->tagCollection($tags)
            );
    }
}
