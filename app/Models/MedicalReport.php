<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'medical_id',
        'report',
        'file_path',
    ];

    public function case()
    {
        return $this->belongsTo(SafeZoneCase::class, 'case_id');
    }

    public function medical()
    {
        return $this->belongsTo(User::class, 'medical_id');
    }
}
