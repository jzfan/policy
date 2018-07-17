<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'tickets_qty', 'openid', 'avatar', 'account', 'qrcode_ticket', 'rank', 'points', 'rank_remain', 'sign_at', 'sign_continuly', 'introducer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'rank_remain'
    ];

    public $timestamps = ['sign_at'];

    // protected $withCount = ['policies_count'];
    
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function firstOrCreateBy($wechatUser)
    {
        return self::where('openid', $wechatUser['id'])->firstOrCreate([
                'openid' => $wechatUser['id']
            ], [
                'name' => $wechatUser['nickname'],
                'api_token' => str_random(60),
                'avatar' => $wechatUser['avatar']
            ]);
    }

    public static function givePoints($id)
    {
        $user = self::findOrFail($id);
        $user->increment('points', 500);
        return $user;
    }

    public function isSignedToday()
    {
        return $this->sign_at !== null && Carbon::parse($this->sign_at)->isToday();
    }

    public function increaseRankByCharge($n)
    {
        $this->increment('rank', $n);
        $this->increment('rank_remain', $n);
    }

    public function introduced()
    {
        return $this->hasMany(self::class, 'introducer_id', 'id');
    }

    public function toArray()
    {
        $used = $this->policies()->whereNotNull('status')->count();
        $signed = $this->isSignedToday();
        return [
            'id' => $this->id,
            'api_token' => $this->api_token,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'tickets_qty' => $this->tickets_qty,
            'tickets_used' => $used,
            'account' => $this->account,
            'qrcode_ticket' => $this->qrcode_ticket,
            'rank' => $this->rank,
            'rank_remain' => $this->rank_remain,
            'points' => $this->points,
            'signed' => $signed,
            'sign_continuly' => $this->sign_continuly
        ];
    }
}