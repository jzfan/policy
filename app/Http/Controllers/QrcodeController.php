<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function store()
    {
    	$app = app('wechat.official_account');
    	$result = $app->qrcode->forever(auth()->id());
    	dd($result);
    }
}
