<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $fillable = ['email', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
