<?php

class DataObject
{
    public $one;
    public $two;
    public $three;
    public $four;
    public $five;
    public $six;
}

class ConstructObject
{
    public $one;
    public $two;
    public $three;
    public $four;
    public $five;
    public $six;

    public function __construct($one, $two, $three, $four, $five, $six)
    {
        $this->one = $one;
        $this->two = $two;
        $this->three = $three;
        $this->four = $four;
        $this->five = $five;
        $this->six = $six;
    }
}

function fillArray($iterations = 5000)
{
    $start = microtime(1);

    for ($i = 0; $i < $iterations; $i++) {
        $array = [
            'one'   => 'test',
            'two'   => 'string',
            'three' => rand(0, 1000),
            'four'  => 'asdasdasdasd',
            'five'  => 'asdasdasdasd',
            'six'   => 'asdasdasdasd',
        ];

        $pool[] = $array;
    }

    return microtime(1) - $start;
}

function fillObject($iterations = 5000)
{
    $start = microtime(1);

    for ($i = 0; $i < $iterations; $i++) {
        $obj = new DataObject;
        $obj->one = 'test';
        $obj->three = 'string';
        $obj->two = rand(0, 1000);
        $obj->four = 'asdasdasdasd';
        $obj->five = 'asdasdasdasd';
        $obj->six = 'asdasdasdasd';

        $pool[] = $obj;
    }

    return microtime(1) - $start;
}

function constructObject($iterations = 5000)
{
    $start = microtime(1);

    for ($i = 0; $i < $iterations; $i++) {
        $obj = new ConstructObject(
            'test',
            'string',
            rand(0, 1000),
            'asdasdasdasd',
            'asdasdasdasd',
            'asdasdasdasd'
        );

        $pool[] = $obj;
    }

    return microtime(1) - $start;
}

$iterations = 100000;
var_dump(str_pad('fillArray', 20) . (string)fillArray($iterations));
var_dump(str_pad('fillObject', 20) . (string)fillObject($iterations));
var_dump(str_pad('constructObject', 20) . (string)constructObject($iterations));
