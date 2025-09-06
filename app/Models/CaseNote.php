<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseNote extends Model
{
    //
    protected $fillable = [
        'case_id',
        'user_id',
        'note',
    ];

    public function case()
    {
        return $this->belongsTo(SafeZoneCase::class, 'case_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
