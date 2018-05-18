<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function update()
    {
    	$data = request()->validate([
    		'type' => 'required|in:increment,decrement',
    		'policy_id' => 'required:exists:policies,id'
    	]);
    	if ($data['type'] == 'increment') {
    		$this->increment($data['policy_id']);
    	}
    }

    protected function increment($policy_id)
    {
		\DB::transaction( function () use ($policy_id) {
			if (Policy::where([
					'id' => $policy_id,
    				'status' => 'lose',
    				'user_id' => auth()->id(),
    			])->lockForUpdate()->get()->isEmpty()) {
				abort(400, 'policy not exists');
			}
			Policy::find($policy_id)->update(['status' => 'rewarded']);
			auth()->user()->increment('account', 200);
		});
    }
}
