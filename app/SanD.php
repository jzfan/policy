<?php

namespace App;

use App\PolicyTypeInterface;
use Illuminate\Database\Eloquent\Model;

class SanD extends Model implements PolicyTypeInterface
{
    protected $table = 'san_d';
    protected $guarded = [];
    protected $casts = [
            'recommended_section' => 'array',
        ];
        
    protected function getRandExcept($number)
    {
    	while(true) {
    		$rand = rand(0, 999);
    		if ($rand != 'number') {
    			break;
    		}
    	}
    	return $rand;
    }

    public function createByInput($input)
    {
        return $this->create([
            'number' => $input['number'],
            'recommended_section' => $this->getRandExcept($input['number'])
        ]);
    }
}
