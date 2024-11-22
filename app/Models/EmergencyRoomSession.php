<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmergencyRoom;

class EmergencyRoomSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'emergency_room_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function department()
    {
        return $this->belongsTo(EmergencyRoom::class);
    }
}
