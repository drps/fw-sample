<?php

namespace App\Http\Action;

class SampleAction
{
    private $testArray;

    public function __construct(array $testArray)
    {
        $this->testArray = $testArray;
    }

    public function dd()
    {
        var_dump($this->testArray);
    }
}
