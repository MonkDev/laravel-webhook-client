<?php

namespace Spatie\WebhookClient\Tests\TestClasses;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class ProcessNothingWebhookProfile implements WebhookProfile
{
    /**
     * 
     * @param Request $request 
     * @return false 
     */
    public function shouldProcess(Request $request)
    {
        return false;
    }
}
