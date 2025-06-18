<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');  
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');  
    }
}


