<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
	protected $guarded = [];
    protected $with = ['insurable'];

	public function insurable()
    {
        return $this->morphTo();
    }

    public function createByType($input)
    {
    	$model = $this->getModel($input['type']);
    	$obj = $model->createByInput($input);
    	return $obj->policy()->create([
    			'period' => date('Ymd'),
    			'user_id' => auth()->id()
    		]);
    }

    protected function getModel($type)
    {
        $class = 'App\\'.studly_case($type);
        return new $class;
    }
}
