<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public $timestamps = ['paid_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
