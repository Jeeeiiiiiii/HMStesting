<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;
use App\Models\Vital;
use App\Models\Test;
use App\Models\Admission;
use App\Models\PatientQrCode;
use App\Models\PatientRecord;
use App\Models\PhysicalAssessment;
use App\Models\Session;
use App\Models\Order;
use App\Models\erOrder;
use App\Models\Record;
use App\Models\RecordQrCode;
use App\Models\OrderQrCode;
use App\Models\erOrderQrCode;
use App\Models\TreatmentPlan;

class Patient extends Authenticatable
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
    protected $guard = 'patient';
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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function admission()
    {
        return $this->hasMany(Admission::class);
    }

    public function vital()
    {
        return $this->hasMany(Vital::class);
    }

    public function test()
    {
        return $this->hasMany(Test::class);
    }

    public function physical_assessment()
    {
        return $this->hasMany(PhysicalAssessment::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function er_order()
    {
        return $this->hasMany(erOrder::class);
    }

    public function record()
    {
        return $this->hasMany(Record::class);
    }

    public function treatment_plan()
    {
        return $this->hasMany(TreatmentPlan::class);
    }

    public function qr_codes()
    {
        return $this->hasMany(PatientQrCode::class);
    }
    public function record_qr_codes()
    {
        return $this->hasMany(RecordQrCode::class);
    }

    public function order_qr_codes()
    {
        return $this->hasMany(OrderQrCode::class);
    }

    public function er_order_qr_codes()
    {
        return $this->hasMany(erOrderQrCode::class);
    }

    public function patientrecord()
    {
        return $this->hasMany(PatientRecord::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
