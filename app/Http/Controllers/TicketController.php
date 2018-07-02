<?php

namespace App\Http\Controllers;

use App\Order;
use App\Billing\PaymentGateway;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $payment;

    public function __construct(PaymentGateway $payment)
    {
        $this->payment = $payment;
    }

    public function byPoints()
    {
        return $this->increaseBy('points', 500, 1);
    }

    public function byRank()
    {
        return $this->increaseBy('rank_remain', 1, 10);
    }

    protected function increaseBy($key, $pay, $got)
    {
        return \DB::transaction(function () use ($key, $pay, $got) {
            $authUser = \DB::table('users')->where('id', auth()->id())->lockForUpdate()->first();
            if ($authUser->$key >= $pay) {
                auth()->user()->update([$key => $authUser->$key - $pay, 'tickets_qty' => $authUser->tickets_qty + $got]);
            }
            return auth()->user();
        });
    }
}
