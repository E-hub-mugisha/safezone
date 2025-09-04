<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeZoneCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'medical_id',
        'case_number',
        'survivor_name',
        'phone',
        'email',
        'type',
        'description',
        'location',
        'status',
    ];


    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function medical()
    {
        return $this->belongsTo(User::class, 'medical_id');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class , 'case_id');
    }
    public function reports()
    {
        return $this->hasMany(MedicalReport::class, 'case_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
