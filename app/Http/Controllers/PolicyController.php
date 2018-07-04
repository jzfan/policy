<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;
use App\Http\Resources\PolicyResource;

class PolicyController extends Controller
{
    public function index()
    {
        return auth()->user()->policies()->whereNotNull('status')->orderBy('id', 'desc')->simplePaginate(5);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                'number' => 'required',
                'code' => 'required',
            ]);
        $policy = Policy::insure($data);
        return response()->json($policy, 201);
    }

    public function active(Policy $policy)
    {
        if (date('H') == '21') {
            abort(400, '开奖中，请等待');
        }
        \DB::transaction( function () use ($policy) {
            $policy->update(['status' => 'active']);
            $policy->user->decrement('tickets_qty');
        });
        return 'actived';
    }

    public function next()
    {
        return auth()->user()->policies()->where('code', request('code'))
                ->where('expect', config('lottery.'.request('code').'.next'))
                ->where('status', null)
                ->first();  
    }

    public function update(Policy $policy)
    {
        $data = request()->validate([
            'status' => 'required|in:rewarded'
        ]);
        $policy->update($data);
        return 'rewarded';
    }

}
