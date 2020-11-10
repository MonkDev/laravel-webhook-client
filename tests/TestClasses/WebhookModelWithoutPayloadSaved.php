<?php

namespace Spatie\WebhookClient\Tests\TestClasses;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;

class WebhookModelWithoutPayloadSaved extends WebhookCall
{
    /**
     * 
     * @param WebhookConfig $config 
     * @param Request $request 
     * @return WebhookCall 
     */
    public static function storeWebhook(WebhookConfig $config, Request $request)
    {
        return WebhookCall::create([
            'name' => $config->name,
            'payload' => [],
        ]);
    }
}
