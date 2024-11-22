<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EROrderStatusChanged extends Notification
{
    use Queueable;

    protected $order;
    protected $status;

    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "The ER medical order status for {$this->order->patient->name} has been changed to {$this->status}.",
            'order_id' => $this->order->id,
            'patient_name' => $this->order->patient->name,
            'url' => route('emergencyroom_patients_profile', ['id' => $this->order->patient_id,
            'notification_id' => $this->id]), // Include URL to order page
        ];
    }
}

