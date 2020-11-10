<?php

namespace Spatie\WebhookClient\Tests;

use Illuminate\Support\Testing\Fakes\QueueFake;
use PHPUnit\Framework\Assert;

class FakeQueue extends QueueFake
{
   public function assertNothingPushed()
   {
       return Assert::assertEmpty($this->jobs, 'Jobs were pushed unexpectedly.');
   }
}