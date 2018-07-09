<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use InsureTrait;
    
	protected $guarded = [];
    protected $casts = [
        'recommend' => 'array',
        'win_number' => 'array'
    ];

    public function lottery()
    {
        return Lottery::where('code', $this->code)->where('expect', $this->expect)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wonOrLose()
    {
        $data = $this->lottery()->checkByRecommend($this->recommend);
        return $this->update($data);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'expect' => $this->expect,
            'status' => $this->status,
            'number' => $this->number,
            'number' => $this->number,
            'win_number' => $this->win_number,
            'recommend' => $this->recommend,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
 
}
