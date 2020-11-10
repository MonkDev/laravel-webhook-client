<?php

namespace Spatie\WebhookClient;

use Exception;
use Illuminate\Http\Request;
use Spatie\WebhookClient\Events\InvalidSignatureEvent;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Models\WebhookCall;

class WebhookProcessor
{
    /**
     * 
     * @var Request
     */
    protected $request;

    /**
     * 
     * @var WebhookConfig
     */
    protected $config;

    public function __construct(Request $request, WebhookConfig $config)
    {
        $this->request = $request;

        $this->config = $config;
    }

    public function process()
    {
        $this->ensureValidSignature();

        if (! $this->config->webhookProfile->shouldProcess($this->request)) {
            return $this->createResponse();
        }

        $webhookCall = $this->storeWebhook();

        $this->processWebhook($webhookCall);

        return $this->createResponse();
    }

    protected function ensureValidSignature()
    {
        if (! $this->config->signatureValidator->isValid($this->request, $this->config)) {
            event(new InvalidSignatureEvent($this->request));

            throw WebhookFailed::invalidSignature();
        }

        return $this;
    }

    /**
     * @return WebhookCall 
     */
    protected function storeWebhook()
    {
        $webhookModel = $this->config->webhookModel;
        return $webhookModel::storeWebhook($this->config, $this->request);
    }

    /**
     * 
     * @param WebhookCall $webhookCall 
     * @return void 
     * @throws Exception 
     */
    protected function processWebhook(WebhookCall $webhookCall)
    {
        try {
            $job = new $this->config->processWebhookJobClass($webhookCall);

            $webhookCall->clearException();

            dispatch($job);
        } catch (Exception $exception) {
            $webhookCall->saveException($exception);

            throw $exception;
        }
    }

    protected function createResponse()
    {
        return $this->config->webhookResponse->respondToValidWebhook($this->request, $this->config);
    }
}
