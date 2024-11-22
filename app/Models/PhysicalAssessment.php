<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Nurse;

class PhysicalAssessment extends Model
{
    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'patient_id',
        'general_appearance',
        'pain_assessment',
        'pain_description',
        'changes_in_condition',
        'assessment_date',
        'nurse_id',
    ];

    // Define the relationship to the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse()
    {
    return $this->belongsTo(Nurse::class);
    }
}
