<?php

namespace Spatie\WebhookClient\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

class WebhookCall extends Model
{
    public $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'exception' => 'array',
    ];

    /**
     * 
     * @param WebhookConfig $config 
     * @param Request $request 
     * @return WebhookCall 
     */
    public static function storeWebhook(WebhookConfig $config, Request $request)
    {
        return self::create([
            'name' => $config->name,
            'payload' => $request->input(),
        ]);
    }

    /**
     * 
     * @param Exception $exception 
     * @return self 
     */
    public function saveException(Exception $exception)
    {
        $this->exception = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $this->save();

        return $this;
    }

    /**
     * 
     * @return self 
     */
    public function clearException()
    {
        $this->exception = null;

        $this->save();

        return $this;
    }
}
