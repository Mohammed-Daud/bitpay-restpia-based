<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vrajroham\LaravelBitpay\Events\BitpayWebhookReceived;

class ProcessBitpayWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle(BitpayWebhookReceived $event)
    {
        $orderId = $event->payload['orderId'];
        $status = $event->payload['status'];
        // Other payload properties
        // You will receive 3 webhooks for single payment with different status.
        // 1. status = paid
        // 2. status = confirmed
        // 3. status = completed
    }
}