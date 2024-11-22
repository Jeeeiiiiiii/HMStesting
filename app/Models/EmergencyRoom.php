<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmergencyRoomSession;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\Admission;
use App\Models\Order;

class EmergencyRoom extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_name',
        'email',
        'password',
        'department_code',
        'phone_number',
        'address',
        'head_id',
    ];
    protected $guard = 'department';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sessions()
    {
        return $this->hasMany(EmergencyRoomSession::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class); 
    }

    public function orders()
    {
        return $this->hasMany(Order::class); 
    }

}
