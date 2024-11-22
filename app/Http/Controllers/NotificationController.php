<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth('doctor')->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        return back();
    }

    public function markAsReadER($id)
    {
        $notification = auth('eroom')->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        return back();
    }

    public function markAsReadPatient($id)
    {
        $notification = auth('patient')->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        return back();
    }

    public function markAsReadPatientDoctor($id)
    {
        $notification = auth('patient')->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        return back();
    }

}
