<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nurse;

class NurseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
