<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function store()
    {
    	$app = app('wechat.official_account');
    	$qrcode = $app->qrcode->forever(auth()->id());
    	auth()->user()->update(['qrcode_ticket' => $qrcode['ticket']]);
    	return $qrcode['ticket'];
    }
}
