<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\erOrder;

class erOrderQrCode extends Model
{
    protected $fillable = [
        'file_path', 
        'patient_record_id',
        'er_order_id',
        'patient_id',
        ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }

    public function order()
    {
        return $this->belongsTo(erOrder::class);
    }
}
