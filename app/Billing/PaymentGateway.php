<?php

namespace App\Billing;

interface PaymentGateway
{
    public function order($data);

    public function handlePaidNotify($closure);
}
