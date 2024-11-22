<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\TriageNurseProfile;
use App\Models\TriageNurseSession;
use App\Models\Department;
use App\Models\PatientRecord;

class TriageNurse extends Authenticatable
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
    protected $guard = 'triagenurse';
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

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function profile()
    {
        return $this->hasOne(TriageNurseProfile::class);
    }
    public function patientRecord()
    {
        return $this->hasMany(PatientRecord::class);
    }

    public function sessions()
    {
        return $this->hasMany(TriageNurseSession::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_triage_nurse');
    }
}
