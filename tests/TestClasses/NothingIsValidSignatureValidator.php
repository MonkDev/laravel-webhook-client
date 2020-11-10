<?php

namespace Spatie\WebhookClient\Tests\TestClasses;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class NothingIsValidSignatureValidator implements SignatureValidator
{
    /**
     *
     * @param Request $request 
     * @param WebhookConfig $config 
     * @return bool 
     */
    public function isValid(Request $request, WebhookConfig $config)
    {
        return false;
    }
}
