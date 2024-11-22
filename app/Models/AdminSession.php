<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class AdminSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'device_name',
        'browser_name',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
