<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Test extends Model
{
    protected $fillable = [
        'patient_id',
        'hpi',
        'note',
        'medication',
        'chief_complaint',
        'diagnose',
    ];

    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
