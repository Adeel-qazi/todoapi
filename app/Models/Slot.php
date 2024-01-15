<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;
    protected $fillable = ['start_time', 'end_time', 'zoom_link'];

    public function events()
    {
        return $this->hasMany(Event::class, 'slot_id','id');
    }
}
