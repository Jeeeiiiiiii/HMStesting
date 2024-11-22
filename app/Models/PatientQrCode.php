<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\PatientRecord;

class PatientQrCode extends Model
{
    protected $fillable = [
        'file_path', 
        'patient_record_id',
        'patient_id',
        'qr_code_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }
}
