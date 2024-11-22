<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\Test;
use App\Models\Vital;
use App\Models\PhysicalAssessment;
use App\Models\PatientRecord;
use App\Models\PatientQrCode;
use App\Models\RecordQrCode;

class Record extends Model
{

    protected $fillable = [
    'patient_id', 
    'doctor_id',
    'nurse_id',
    'patient_record_id', 
    'vital_id', 
    'physical_assessment_id', 
    'rounds', 
    'admitting_date_and_time',
    ];

    protected $dates = [
        'admitting_date_and_time', 
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function vital()
    {
        return $this->belongsTo(Vital::class);
    }

    public function physical_assessment()
    {
        return $this->belongsTo(PhysicalAssessment::class);
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }

    public function record_qrcode()
    {
        return $this->hasMany(RecordQrCode::class);
    }

}
