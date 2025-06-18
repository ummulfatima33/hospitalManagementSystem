<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor_details extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
