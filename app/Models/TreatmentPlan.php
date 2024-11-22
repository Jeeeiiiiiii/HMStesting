<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\Test;
use App\Models\PatientRecord;

class TreatmentPlan extends Model
{
    protected $fillable = [
        'patient_id', 
        'doctor_id',
        'nurse_id',
        'patient_record_id', 
        'test_id', 
        'title', 
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

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }


}
