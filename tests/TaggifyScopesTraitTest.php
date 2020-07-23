<?php

namespace AmitKD\LaravelTaggify\Tests;

use Illuminate\Support\Str;
use PostStub;
use TagStub;

class TaggifyScopesTraitTest extends BaseTestCase
{
    protected $post;
    protected $post2;
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

        $this->post2 = PostStub::create([
            'title' => 'Test Post 2 Title'
        ]);
    }

    public function test_it_can_get_the_models_with_any_given_tag()
    {
        $this->post->addTags(['Laravel', 'PHP']);

        $this->post2->addTags(['Laravel']);

        $post = PostStub::withAnyTag(['Laravel'])->get();

        $this->assertCount(2, $post);
    }
}
