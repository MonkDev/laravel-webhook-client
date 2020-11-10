<?php

namespace Spatie\WebhookClient;

use LogicException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;
use Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;

class WebhookConfig
{
    /** @var string */
    public $name;

    /** @var string */
    public $signingSecret;

    /** @var string */
    public $signatureHeaderName;

    /** @var SignatureValidator */
    public $signatureValidator;

    /** @var WebhookProfile */
    public $webhookProfile;

    /** @var RespondsToWebhook */
    public $webhookResponse;

    /** @var string */
    public $webhookModel;

    /** @var string */
    public $processWebhookJobClass;

    /**
     * 
     * @param array $properties 
     * @return void 
     * @throws InvalidConfig 
     * @throws LogicException 
     * @throws BindingResolutionException 
     */
    public function __construct($properties)
    {
        $this->name = $properties['name'];

        $this->signingSecret = isset($properties['signing_secret']) ? $properties['signing_secret'] : '';

        $this->signatureHeaderName = isset($properties['signature_header_name']) ? $properties['signature_header_name'] : '';

        if (! is_subclass_of($properties['signature_validator'], SignatureValidator::class)) {
            throw InvalidConfig::invalidSignatureValidator($properties['signature_validator']);
        }
        $this->signatureValidator = app($properties['signature_validator']);

        if (! is_subclass_of($properties['webhook_profile'], WebhookProfile::class)) {
            throw InvalidConfig::invalidWebhookProfile($properties['webhook_profile']);
        }
        $this->webhookProfile = app($properties['webhook_profile']);

        $webhookResponseClass = isset($properties['webhook_response']) ? $properties['webhook_response'] : DefaultRespondsTo::class;
        if (! is_subclass_of($webhookResponseClass, RespondsToWebhook::class)) {
            throw InvalidConfig::invalidWebhookResponse($webhookResponseClass);
        }
        $this->webhookResponse = app($webhookResponseClass);

        $this->webhookModel = $properties['webhook_model'];

        if (! is_subclass_of($properties['process_webhook_job'], ProcessWebhookJob::class)) {
            throw InvalidConfig::invalidProcessWebhookJob($properties['process_webhook_job']);
        }
        $this->processWebhookJobClass = $properties['process_webhook_job'];
    }
}
