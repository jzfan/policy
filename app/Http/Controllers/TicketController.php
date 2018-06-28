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
        return \DB::transaction(function () {
            $authUser = \DB::table('users')->where('id', auth()->id())->lockForUpdate()->first();
            if ($authUser->points >= 500) {
                auth()->user()->update(['points' => $authUser->points-500, 'tickets_qty' => $authUser->tickets_qty+1]);
            }
            return auth()->user();
        });
    }

    public function byRank()
    {
        return \DB::transaction(function () {
            $authUser = \DB::table('users')->where('id', auth()->id())->lockForUpdate()->first();
            if ($authUser->rank_remain >= 1) {
                auth()->user()->update(['rank_remain' => $authUser->rank_remain-1, 'tickets_qty' => $authUser->tickets_qty+10]);
            }
            return auth()->user();
        });
    }
}
