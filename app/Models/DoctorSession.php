<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class DoctorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
