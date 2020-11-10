<?php

namespace Spatie\WebhookClient;

class WebhookConfigRepository
{
    /** @var \Spatie\WebhookClient\WebhookConfig[] */
    protected $configs;

    public function addConfig(WebhookConfig $webhookConfig)
    {
        $this->configs[$webhookConfig->name] = $webhookConfig;
    }
    
    /**
     * 
     * @param string $name 
     * @return \Spatie\WebhookClient\WebhookConfig|null
     */
    public function getConfig($name)
    {
        return isset($this->configs[$name]) ? $this->configs[$name] : null;
    }
}
