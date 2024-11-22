<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class DoctorProfile extends Model
{
    protected $fillable = [
        'doctor_id',
        'name',
        'age',
        'birthday',
        'birthplace',
        'civil_status',
        'specialization',
        'religion',
        'nationality',
        'gender',
        'telephone_no',
        'emergency_email',
        'emergency_telephone_no',
    ];

    protected $dates = [
        'birthday',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
