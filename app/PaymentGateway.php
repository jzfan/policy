<?php

namespace App;

interface PaymentGateway
{
    public function prepay($data);

    public function handlePaidNotify($closure);
}
