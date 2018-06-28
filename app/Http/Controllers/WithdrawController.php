<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billing\PaymentGateway;

class WithdrawController extends Controller
{
	protected $payment;

	public function __construct(PaymentGateway $payment)
	{
		$this->payment = $payment;
	}

    public function withdraw()
    {
        return $this->payment->withdraw();
    }
}
