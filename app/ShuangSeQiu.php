<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShuangSeQiu extends Model implements PolicyTypeInterface
{
    protected $table = 'shuang_se_qiu';
    protected $guarded = [];

    public function policy()
    {
        return $this->morphOne(Policy::class, 'insurable');
    }

    public function createByInput($input)
    {
    	return $this->create([
    		'number' => $input['number'],
    		'recommended_number' => $this->getRandExcept($input['number'])
    	]);
    }

    protected function getRandExcept($number)
    {
        while(true) {
            $rand = rand(1, 16);
            if ($number == $rand) {
                return $rand;
            }
        }
    }
}
