<?php

namespace App\Http\Controllers;

use App\Lottery;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function count()
    {
        $data = request()->validate([
            'code' => 'required|in:ssq,fc3d'
        ]);
        $method = 'count' . studly_case($data['code']) . 'ByWinNumber';
        return Lottery::$method($data);
    }
}
