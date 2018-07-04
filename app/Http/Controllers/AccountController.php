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
    		return $this->increment($data['policy_id']);
    	}
    }

    protected function increment($policy_id)
    {
		return \DB::transaction( function () use ($policy_id) {
			if (Policy::where([
					'id' => $policy_id,
    				'status' => 'lose',
    				'user_id' => auth()->id(),
    			])->lockForUpdate()->get()->isEmpty()) {
				abort(400, 'policy not exists');
			}
            $reward = $this->reward();
            auth()->user()->increment('account', $reward * 100 );
			Policy::find($policy_id)->update(['status' => 'rewarded']);
            return $reward;
		});
    }

    protected function reward()
    {
        $lucky = rand(1, 1000);
        if ($lucky === 1) {
            $yuan = rand(9, 66);
        } elseif ($lucky >=2 && $lucky < 12) {
            $yuan = rand(1, 8);
        } else {
            $yuan = 0;
        }
        return config('global.hongbao') + $yuan;
    }
}
