<?php

namespace App;

interface PaymentGateway
{
    public function charge($data);

    public function notify();
}
