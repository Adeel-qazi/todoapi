<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id', 'plan_name', 'price', 'start_date', 'close_date', 'active'];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
