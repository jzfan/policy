<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;
use App\Http\Resources\PolicyResource;

class PolicyController extends Controller
{
    public function index()
    {
        return auth()->user()->policies()->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                'number' => 'required',
                'code' => 'required',
            ]);
        // if (Policy::hasInsured($data)) {
        //     return;
        // }
        $policy = Policy::insure($data);
        return response()->json($policy, 201);
    }

    public function active(Policy $policy)
    {
        $policy->update(['status' => 'active']);
        $policy->user->decrement('tickets_qty');
        return 'actived';
    }

    public function next()
    {
        return auth()->user()->policies()->where('code', request('code'))
                ->where('expect', config('lottery.'.request('code').'.next'))
                ->where('status', null)
                ->first();  
    }

}
