<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeZoneCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_id',
        'medical_id',
        'type',
        'description',
        'location',
        'status',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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
}
