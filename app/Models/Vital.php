<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Vital extends Model
{
    protected $fillable = [
        'patient_id',
        'body_temperature',
        'blood_pressure',
        'respiratory_rate',
        'weight',
        'height',
        'pulse_rate',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
