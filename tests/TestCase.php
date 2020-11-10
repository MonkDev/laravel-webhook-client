<?php

namespace Spatie\WebhookClient\Tests;

use CreateWebhookCallsTable;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Assert as PHPUnit;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Spatie\WebhookClient\WebhookClientServiceProvider;

class TestCase extends Orchestra
{

    /**
     * The previous exception handler.
     *
     * @var ExceptionHandler|null
     */
    protected $previousExceptionHandler;

    public function setUp()
    {
        parent::setUp();
        
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            WebhookClientServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_webhook_calls_table.php.stub';

        (new CreateWebhookCallsTable())->up();
    }

    /**
     * Restore exception handling.
     *
     * @return $this
     */
    protected function withExceptionHandling()
    {
        if ($this->previousExceptionHandler) {
            $this->app->instance(ExceptionHandler::class, $this->previousExceptionHandler);
        }

        return $this;
    }

    /**
     * Disable exception handling for the test.
     *
     * @return $this
     */
    protected function withoutExceptionHandling()
    {
        $this->previousExceptionHandler = app(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new FakeExceptionHandler());

        return $this;
    }
}
