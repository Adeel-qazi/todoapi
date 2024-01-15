<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = ['client_id','title','start_time', 'end_time', 'zoom_link'];


    public function client()
    {
        return $this->belongsTo(User::class);
    }


    // public function appointment()
    // {
    //     return $this->belongsTo(Appointment::class, 'event_id','id');
    // }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'event_id','id');
    }

    // public function appointments()
    // {
    //     return $this->belongsToMany(Appointment::class,'team_id','event_id')->with;
    // }
}
