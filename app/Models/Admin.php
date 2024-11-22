<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\BedControl;
use App\Models\TriageNurse;
use App\Models\Department;
use App\Models\ChargeNurse;
use App\Models\AdminProfile;
use App\Models\AdminSession;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guard = 'admin';
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

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function nurses()
    {
        return $this->hasMany(Nurse::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function chargenurses()
    {
        return $this->hasMany(ChargeNurse::class);
    }

    public function triagenurses()
    {
        return $this->hasMany(TriageNurse::class);
    }

    public function bedcontrols()
    {
        return $this->hasMany(BedControl::class);
    }

    public function profile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function sessions()
    {
        return $this->hasMany(AdminSession::class);
    }
}
