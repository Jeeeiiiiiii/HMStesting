<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\PatientRecord;
use App\Models\DoctorSession;
use App\Models\DoctorProfile;
use App\Models\Department;

class Doctor extends Authenticatable
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
    protected $guard = 'doctor';
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

    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class);
    }

    public function sessions()
    {
        return $this->hasMany(DoctorSession::class);
    }

    public function profile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_doctor');
    }

    public function patients()
    {
        return $this->hasMany(PatientRecord::class, 'doctor_id')->select('patient_id', 'status')->distinct();
    }




    
}
