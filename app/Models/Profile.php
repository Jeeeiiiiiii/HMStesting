<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Profile extends Model
{
    protected $fillable = [
        'patient_id',
        'name',
        'age',
        'birthday',
        'birthplace',
        'civil_status',
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

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
