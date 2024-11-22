<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PatientQrCode;
use App\Models\PatientRecord;
use App\Models\RecordQrCode;
use App\Models\Record;
use App\Models\Order;
use App\Models\erOrder;

class QrCodeController extends Controller
{
    public function show($patientRecordId)
{
    $patientRecord = PatientRecord::with('qrcode')->find($patientRecordId);

    if ($patientRecord && $patientRecord->qrcode->isNotEmpty()) {
        // Get the first QR code associated with this PatientRecord
        $qrCode = $patientRecord->qrcode->first();

        // Use Storage::disk('s3')->url to get the correct URL for the QR code
        return response()->json(['path' => Storage::disk('s3')->url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}


    public function showRecord($patientRecordId)
    {
        $record = Record::with('record_qrcode')->find($patientRecordId);

        if ($record && $record->record_qrcode->isNotEmpty()) {
            // Get the first QR code associated with this Record
            $qrCode = $record->record_qrcode->first();

            // Use Storage::disk('s3')->url to get the correct URL for the QR code
            return response()->json(['path' => Storage::disk('s3')->url($qrCode->file_path)]);
        } else {
            return response()->json(['path' => null], 404); // Handle the case where no QR code is found
        }
    }


    public function showOrder($patientRecordId)
{
    $order = Order::with('order_qrcode')->find($patientRecordId);

    if ($order && $order->order_qrcode->isNotEmpty()) {
        // Get the first QR code associated with this Order
        $qrCode = $order->order_qrcode->first();

        // Use Storage::disk('s3')->url to get the correct URL for the QR code
        return response()->json(['path' => Storage::disk('s3')->url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}

    public function showerOrder($patientRecordId)
{
    $order = erOrder::with('order_qrcode')->find($patientRecordId);

    if ($order && $order->order_qrcode->isNotEmpty()) {
        // Get the first QR code associated with this Order
        $qrCode = $order->order_qrcode->first();

        // Use Storage::disk('s3')->url to get the correct URL for the QR code
        return response()->json(['path' => Storage::disk('s3')->url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}

        public function showAbstract($patientRecordId)
{
    $order = PatientRecord::with('abstract_qrcode')->find($patientRecordId);

    if ($order && $order->abstract_qrcode->isNotEmpty()) {
        // Get the first QR code associated with this Order
        $qrCode = $order->abstract_qrcode->first();

        // Use Storage::disk('s3')->url to get the correct URL for the QR code
        return response()->json(['path' => Storage::disk('s3')->url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}


}