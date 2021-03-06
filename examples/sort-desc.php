<?php

require '../vendor/autoload.php';

use WillEvil\Heap;

class MaxHeap extends Heap
{
    /**
     * MaxHeap constructor.
     *
     * @param array $arr
     */
    public function __construct(array $arr = [])
    {
        parent::__construct($arr, true);
    }

    /**
     * @param $item1
     * @param $item2
     *
     * @return bool
     */
    protected function compare($item1, $item2): bool
    {
        return $item1 > $item2;
    }
}

$arr = [45, 78, 12, 1, 45, 69];

$maxHeap = new MaxHeap($arr);

print_r($maxHeap->sort());



