<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TriageNurse;

class TriageNurseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'triage_nurse_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function triage_nurse()
    {
        return $this->belongsTo(TriageNurse::class);
    }
}
