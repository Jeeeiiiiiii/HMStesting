<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

