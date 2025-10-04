<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ["reference", "email", "amount", "status", "user_id", "plan", "plan_id", "limit"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
