<?php

namespace AmitKD\LaravelTaggify\Tests;

use Illuminate\Support\Str;
use PostStub;
use TagStub;

class TaggifyTraitTest extends BaseTestCase
{
    protected $post;
    protected $tags;

    public function setUp(): void
    {
        parent::setUp();

        $this->tags = [
            'Laravel',
            'PHP',
            'WordPress',
            'JavaScript',
            'Python',
            'Django',
            'Spring Framework'
        ];

        foreach ($this->tags as $tag) {
            TagStub::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
                'count' => 0
            ]);
        }

        $this->post = PostStub::create([
            'title' => 'Test Post 1 Title'
        ]);
    }

    public function test_it_can_attach_existing_tags_to_a_model()
    {
        $tags = ['Laravel', 'Spring Framework'];

        $tag_slugs = ['laravel', 'spring-framework'];

        $this->post->addTags($tags);

        $this->assertCount(2, $this->post->tags);

        foreach ($tag_slugs as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('slug'));
        }
    }

    public function test_it_can_attach_new_tags_to_a_model()
    {
        $tags = ['Laravel', 'Spring Framework', 'Java', 'VueJs'];

        $tag_slugs = ['laravel', 'spring-framework', 'java', 'vuejs'];

        $this->post->addTags($tags);

        $this->assertCount(4, $this->post->tags);

        foreach ($tag_slugs as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('slug'));
        }
    }

    public function test_it_can_attach_existing_tag_id_to_a_model()
    {
        $tags = [1, 2];

        $tag_ids = [1, 2];

        $this->post->addTags($tags);

        $this->assertCount(2, $this->post->tags);

        foreach ($tag_ids as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('tags.id'));
        }
    }

    public function test_it_can_attach_combination_of_model_id_and_name_to_a_model()
    {
        $tag1 = TagStub::findOrFail(1);

        $tag2 = TagStub::findOrFail(2);

        $tags = [$tag1, $tag2, 3, 4, 'Python', 'non existing tag'];

        $tag_slugs = [$tag1->slug, $tag2->slug, 'wordpress', 'javascript', 'python', 'non-existing-tag'];

        $this->post->addTags($tags);

        $this->assertCount(6, $this->post->tags);

        foreach ($tag_slugs as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('tags.slug'));
        }
    }

    public function test_it_can_attach_existing_tag_models_to_a_model()
    {
        $tag1 = TagStub::findOrFail(1);

        $tag2 = TagStub::findOrFail(2);

        $tags = [$tag1, $tag2];

        $tag_ids = [1, 2];

        $this->post->addTags($tags);

        $this->assertCount(2, $this->post->tags);

        foreach ($tag_ids as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('tags.id'));
        }
    }

    public function test_it_generates_unique_slug()
    {
        $tags = ['Java', 'C', 'C#', 'C++', 'java', 'c'];

        $tag_slugs = ['java', 'c', 'c-1', 'c-2', 'java', 'c'];

        $this->post->addTags($tags);

        $this->assertCount(6, $this->post->tags);

        foreach ($tag_slugs as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags()->pluck('slug'));
        }
    }

    public function test_it_can_retag_a_model()
    {
        $tags = TagStub::whereIn('slug', ['laravel', 'php'])->get()->pluck('id')->toArray();

        $re_tags = TagStub::whereIn('slug', ['laravel', 'php', 'python'])->get()->pluck('id')->toArray();

        $tag_slugs = ['laravel', 'php', 'python'];

        $this->post->addTags($tags);

        $this->post->reTag($re_tags);

        $this->assertCount(3, $this->post->tags);

        foreach ($tag_slugs as $tag) {
            $this->assertStringContainsString($tag, $this->post->tags->pluck('slug'));
        }
    }

    public function test_it_can_detach_tags_from_a_model()
    {
        $tag1 = TagStub::findOrFail(1);

        $tag2 = TagStub::findOrFail(2);

        $tags = [$tag1, $tag2, 3, 4, 'Python', 'non existing tag', 'spring-framework'];

        $this->post->addTags($tags);

        $this->post->removeTags([$tag1, $tag2, 'Python', 'non existing tag']);

        $this->assertCount(3, $this->post->tags);

        $tag_slugs = [$tag1->slug, $tag2->slug, 'python', 'non-existing-tag'];

        foreach ($tag_slugs as $tag) {
            $this->assertStringNotContainsString($tag, $this->post->tags()->pluck('tags.slug'));
        }
    }

    public function test_it_can_detach_all_tags_from_a_model()
    {
        $tags = ['Laravel', 'Spring Framework', 'Java', 'VueJs'];

        $tag_slugs = ['laravel', 'spring-framework', 'java', 'vuejs'];

        $this->post->addTags($tags);

        $this->post->with('tags');

        $this->post->removeAllTags();

        $this->assertEquals(0, $this->post->tags()->count());

        foreach ($tag_slugs as $tag) {
            $this->assertStringNotContainsString($tag, $this->post->tags()->pluck('tags.slug'));
        }
    }
}
