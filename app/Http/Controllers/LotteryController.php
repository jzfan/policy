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
        $method = 'count' . studly_case($data['code']);
        return Lottery::$method(100);
    }

    public function current()
    {
        return Lottery::current();
    }

    public function history($code)
    {
        return Lottery::where('code', $code)->orderBy('expect', 'desc')->paginate(10);
    }
}
