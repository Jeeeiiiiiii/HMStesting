<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TriageNurse;

class TriageNurseProfile extends Model
{
    protected $fillable = [
        'triage_nurse_id',
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

    public function triage_nurse()
    {
        return $this->belongsTo(TriageNurse::class);
    }
}
