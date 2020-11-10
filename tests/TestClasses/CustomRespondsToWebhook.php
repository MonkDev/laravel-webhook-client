<?php

namespace Spatie\WebhookClient\Tests\TestClasses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use LogicException;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class CustomRespondsToWebhook implements RespondsToWebhook
{
    /**
     * 
     * @param Request $request 
     * @param WebhookConfig $config 
     * @return Response 
     * @throws LogicException 
     * @throws BindingResolutionException 
     */
    public function respondToValidWebhook(Request $request, WebhookConfig $config)
    {
        return response()->json(['foo' => 'bar']);
    }
}
