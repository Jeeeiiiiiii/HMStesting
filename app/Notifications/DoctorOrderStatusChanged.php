<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DoctorOrderStatusChanged extends Notification
{
    use Queueable;

    protected $patient;
    protected $patientStatus;

    public function __construct($patient, $patientStatus)
    {
        $this->order = $patient;
        $this->status = $patientStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Your Admission status, {$this->order->name}, has been changed to {$this->status}.",
            'order_id' => $this->order->id,
            'patient_name' => $this->order->name,
            'url' => route('patient_dashboard', ['id' => $this->order->patient_id,
            'notification_id' => $this->id]), // Include URL to order page
        ];
    }
}

