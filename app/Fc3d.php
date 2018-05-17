<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fc3d
{

	protected $bai;
	protected $shi;
	protected $ge;

	public function __construct($opencode)
	{
		$arr = explode(',', $opencode);
		$this->bai = $arr[0];
		$this->shi = $arr[1];
		$this->ge = $arr[2];
	}

    public function check($recommend)
    {
    	$win_number = [
    		'bai' => $this->intersect($this->bai, $recommend['bai']),
    		'shi' => $this->intersect($this->shi, $recommend['shi']),
    		'ge' => $this->intersect($this->ge, $recommend['ge']),
    	];
    	$status = empty(array_filter($win_number)) ? 'lose' : 'won';
    	return compact(['status', 'win_number']);
    }

    public function intersect($n, $arr)
    {
    	return in_array($n, $arr) ? $n : null;
    }
}
