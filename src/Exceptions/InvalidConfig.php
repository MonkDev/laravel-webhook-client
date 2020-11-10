<?php

namespace Spatie\WebhookClient\Exceptions;

use Exception;
use Spatie\WebhookClient\ProcessWebhookJob;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;

class InvalidConfig extends Exception
{
    /**
     * 
     * @param string $notFoundConfigName 
     * @return InvalidConfig 
     */
    public static function couldNotFindConfig($notFoundConfigName)
    {
        return new static("Could not find the configuration for `{$notFoundConfigName}`");
    }

    /**
     * 
     * @param string $notFoundConfigName 
     * @return InvalidConfig 
     */
    public static function invalidSignatureValidator($invalidSignatureValidator)
    {
        $signatureValidatorInterface = SignatureValidator::class;

        return new static("`{$invalidSignatureValidator}` is not a valid signature validator class. A valid signature validator is a class that implements `{$signatureValidatorInterface}`.");
    }

    /**
     * 
     * @param string $notFoundConfigName 
     * @return InvalidConfig 
     */
    public static function invalidWebhookProfile($webhookProfile)
    {
        $webhookProfileInterface = WebhookProfile::class;

        return new static("`{$webhookProfile}` is not a valid webhook profile class. A valid web hook profile is a class that implements `{$webhookProfileInterface}`.");
    }

    /**
     * 
     * @param string $notFoundConfigName 
     * @return InvalidConfig 
     */
    public static function invalidWebhookResponse($webhookResponse)
    {
        $webhookResponseInterface = RespondsToWebhook::class;

        return new static("`{$webhookResponse}` is not a valid webhook response class. A valid webhook response is a class that implements `{$webhookResponseInterface}`.");
    }

    /**
     * 
     * @param string $notFoundConfigName 
     * @return InvalidConfig 
     */
    public static function invalidProcessWebhookJob($processWebhookJob)
    {
        $abstractProcessWebhookJob = ProcessWebhookJob::class;

        return new static("`{$processWebhookJob}` is not a valid process webhook job class. A valid class should implement `{$abstractProcessWebhookJob}`.");
    }
}
