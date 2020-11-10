<?php

namespace Spatie\WebhookClient\Tests;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Symfony\Component\Console\Application as ConsoleApplication;

class FakeExceptionHandler implements ExceptionHandler
{
    public function __construct(){}

    public function report(Exception $e) {}
    
    public function render($request, Exception $e) {
        throw $e;
    }
    public function renderForConsole($output, Exception $e) {
        (new ConsoleApplication)->renderException($e, $output);
    }
}