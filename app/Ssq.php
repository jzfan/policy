<?php

namespace App;

class Ssq
{
    protected $opencode;
    protected $red;
    protected $blue;

    public function __construct($opencode)
    {
        $this->opencode = $opencode;
        $arr = explode('+', $this->opencode);
        $this->red = explode(',', $arr[0]);
        $this->blue = $arr[1];
    }


    public function check($recommend)
    {
        $win_number = [
            'red' => $this->intersect($this->red, $recommend['red']),
            'blue' => $this->intersect([$this->blue], $recommend['blue']),
        ]; 
        $status = empty(array_filter($win_number)) ? 'lose' : 'won';
        return compact(['status', 'win_number']);
    }

    protected function intersect($arr1, $arr2)
    {
        return array_values(array_intersect($arr1, $this->addZero($arr2)));
    }

    protected function addZero($arr)
    {
        return array_map(function ($v) {
            return str_pad($v, 2, '0', STR_PAD_LEFT);
        }, $arr);
    }

}
