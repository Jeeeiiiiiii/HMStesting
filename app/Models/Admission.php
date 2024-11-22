<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Department;

class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'room',
        'doctor_id',
        'nurse_id',
        'department_id',
    ];


    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurse_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
