<?php

namespace App;

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
        'name', 'email', 'password', 'api_token', 'tickets_qty', 'openid', 'avatar', 'account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function toArray()
    {
        $used = $this->policies()->whereNotNull('status')->count();
        return [
            'api_token' => $this->api_token,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'tickets_qty' => $this->tickets_qty,
            'tickets_used' => $used,
            'account' => $this->account
        ];
    }
}