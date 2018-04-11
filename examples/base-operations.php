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

/*
 * Returns a heap as an array
 */
echo 'Heap as array:', "\n";
print_r($maxHeap->toArray());

/*
 * Get the heap root
 */
try {
    echo 'Top root: ', $maxHeap->top(), "\n";
    print_r($maxHeap->toArray());
} catch (\Exception $e) {
    echo $e->getMessage();
}

/*
 * Extracts the heap root
 */
try {
    echo 'Extract root: ', $maxHeap->extractTop(), "\n";
    print_r($maxHeap->toArray());
} catch (\Exception $e) {
    echo $e->getMessage();
}

/*
 * Extracts by index
 */
try {
    echo 'Extract by index: ', $maxHeap->extract(2), "\n";
    print_r($maxHeap->toArray());
} catch (\Exception $e) {
    echo $e->getMessage();
}

/*
 * Count
 */
echo 'Count: ', $maxHeap->count(), "\n";

/*
 * Insert
 */
$item = 35;
echo 'Insert Item=', $item, "\n";
$maxHeap->insert($item);
print_r($maxHeap->toArray());

$item = 85;
echo 'Insert Item=', $item, "\n";
$maxHeap->insert($item);
print_r($maxHeap->toArray());

/*
 * Sort.
 * If was created max heap, will implement DESC sort.
 * If was created min heap, will implement ASC sort.
 */
echo 'DESC Sort:', "\n";
print_r($maxHeap->sort());

/*
 * Is Empty. Get true if heap is empty.
 */
echo 'Heap is empty: ', (int) $maxHeap->isEmpty(), "\n";

