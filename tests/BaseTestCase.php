<?php

namespace AmitKD\LaravelTaggify\Tests;

use AmitKD\LaravelTaggify\Providers\TaggifyServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [TaggifyServiceProvider::class];
    }

    public function setUp():void
    {
        parent::setUp();

        Model::unguard();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/../migrations'),
        ]);
    }

    public function tearDown():void
    {
        \Schema::drop('posts');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        \Schema::create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
}
