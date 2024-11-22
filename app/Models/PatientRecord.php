<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Profile;
use App\Models\Test;
use App\Models\Vital;
use App\Models\Admission;
use App\Models\PatientQrCode;
use App\Models\Record;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\EmergencyRoom;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\erOrder;
use App\Models\RecordQrCode;
use App\Models\OrderQrCode;
use App\Models\AbstractQrCode;
use App\Models\TreatmentPlan;

class PatientRecord extends Model
{
    protected $fillable = ['patient_id', 'profile_id', 'test_id', 'vital_id', 'admission_id', 'doctor_id','nurse_id', 'triage_nurse_id', 'reason_for_admission', 'admitting_date_and_time'];

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
    public function triage_nurse()
    {
        return $this->belongsTo(TriageNurse::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function vital()
    {
        return $this->belongsTo(Vital::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function eroom()
    {
        return $this->belongsTo(EmergencyRoom::class);
    }

    public function record()
    {
        return $this->hasMany(Record::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function er_order()
    {
        return $this->hasOne(erOrder::class);
    }

    public function qrcode()
    {
        return $this->hasMany(PatientQrCode::class, 'patient_record_id');
    }

    public function record_qrcode()
    {
        return $this->hasMany(RecordQrCode::class);
    }

    public function order_qrcode()
    {
        return $this->HasMany(OrderQrCode::class);
    }

    public function abstract_qrcode()
    {
        return $this->HasMany(AbstractQrCode::class);
    }

    public function treatment_plan()
    {
        return $this->hasMany(TreatmentPlan::class);
    }
}
