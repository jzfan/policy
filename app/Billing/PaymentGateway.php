<?php

namespace App\Billing;

interface PaymentGateway
{
    public function prepay($data);

    public function handlePaidNotify($closure);
}
