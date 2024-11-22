<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\DepartmentSession;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\Admission;
use App\Models\Order;
use App\Models\erOrder;

class Department extends Authenticatable
{
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
        return $this->hasMany(DepartmentSession::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'department_doctor');
    }

    public function nurses()
    {
        return $this->belongsToMany(Nurse::class, 'department_nurse');
    }

    public function triage_nurse()
    {
        return $this->belongsToMany(TriageNurse::class, 'department_triage_nurse');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class); 
    }

    public function orders()
    {
        return $this->hasMany(Order::class); 
    }

    public function er_orders()
    {
        return $this->hasMany(erOrder::class); 
    }

}
