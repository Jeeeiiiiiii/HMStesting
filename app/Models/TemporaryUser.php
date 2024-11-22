<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [   
        'email',
        'registration_token',       
    ];

    protected $table = 'temporary_users';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
