<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nurse;

class NurseProfile extends Model
{
    protected $fillable = [
        'nurse_id',
        'name',
        'age',
        'birthday',
        'birthplace',
        'civil_status',
        'religion',
        'nationality',
        'gender',
        'telephone_no',
        'emergency_email',
        'emergency_telephone_no',
    ];

    protected $dates = [
        'birthday',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
