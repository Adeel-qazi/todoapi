<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['team_id','event_id','date'];
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(User::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
