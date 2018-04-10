<?php

namespace WillEvil;

/**
 * Class Heap
 *
 * @package WillEvil
 */
abstract class Heap
{
    /** @var array */
    private $heap = [];

    /** @var bool */
    private $maxHeap = true;

    /**
     * Heap constructor.
     *
     * @param array $arr
     * @param bool $maxHeap
     */
    public function __construct(array $arr = [], bool $maxHeap = true)
    {
        $this->maxHeap = $maxHeap;
        $this->buildHeap($arr);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->heap);
    }

    /**
     * @param $item
     *
     * @return bool
     */
    public function insert($item): bool
    {
        $index = $this->count();

        $this->heap[$index] = $item;

        try {
            $this->shiftUp($index);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function top()
    {
        $this->checkEmpty();

        return reset($this->heap);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function extractTop()
    {
        $this->checkEmpty();

        $index = $this->shiftDown(key($this->heap));

        $value = $this->heap[$index];
        unset($this->heap[$index]);

        return $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->heap;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @param int $index
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function shiftUp(int $index): bool
    {
        $parentIndex = $this->getParentIndex($index);

        $child = $this->heap[$index];
        $parent = $this->heap[$parentIndex];

        if ($this->compareByType($child, $parent)) {
            $this->swap($index, $parentIndex);

            return $this->shiftUp($parentIndex);
        }

        return true;
    }

    /**
     * Shift down element and get element index.
     *
     * @param int $index
     *
     * @return int
     *
     * @throws \Exception
     */
    private function shiftDown(int $index): int
    {
        $childIndex = $this->getBestChildIndex($index);
        if ($childIndex !== 0) {
            $this->swap($index, $childIndex);

            return $this->shiftDown($childIndex);
        }

        return $index;
    }

    /**
     * @param int $childIndex
     *
     * @return int
     */
    private function getParentIndex(int $childIndex): int
    {
        return (int) floor($childIndex / 2);
    }

    /**
     * @param int $parentIndex
     *
     * @return array
     */
    private function getChildrenIndexes(int $parentIndex): array
    {
        $product = 2 * $parentIndex;
        $indexLeft = $product + 1;
        $indexRight = $product + 2;

        return [
            $indexLeft,
            $indexRight,
        ];
    }

    /**
     * @param int $parentIndex
     *
     * @return int
     */
    private function getBestChildIndex(int $parentIndex): int
    {
        list($indexLeft, $indexRight) = $this->getChildrenIndexes($parentIndex);

        if (!isset($this->heap[$indexLeft]) && $this->heap[$indexRight]) {
            return 0;
        }

        if (!isset($this->heap[$indexLeft]) || $this->heap[$indexRight]) {
            return isset($this->heap[$indexLeft]) ? $indexLeft : $indexRight;
        }

        $leftVal = $this->heap[$indexLeft];
        $rightVal = $this->heap[$indexRight];

        $res = $this->compare($leftVal, $rightVal);
        $res = true === $this->maxHeap ? $res : !$res;

        return $res ? $indexLeft : $indexRight;
    }

    /**
     * @throws \Exception
     */
    private function checkEmpty()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Heap is empty');
        }
    }

    /**
     * @param int $index1
     * @param int $index2
     *
     * @throws \Exception
     */
    private function swap(int $index1, int $index2)
    {
        if (!isset($this->heap[$index1]) || !isset($this->heap[$index2])) {
            throw new \Exception('One or both of the indexes do not exist in an array');
        }

        list($this->heap[$index1], $this->heap[$index2]) = [$this->heap[$index2], $this->heap[$index1]];
    }

    /**
     * @param array $arr
     *
     * @return int
     */
    private function buildHeap(array $arr): int
    {
        foreach ($arr as $item) {
            $this->insert($item);
        }

        return $this->count();
    }

    /**
     * @param $child
     * @param $parent
     *
     * @return bool
     */
    private function compareByType($child, $parent): bool
    {
        if (true === $this->maxHeap) {
            return $this->compare($child, $parent);
        } else {
            return $this->compare($parent, $child);
        }
    }

    /**
     * Returns true if the first element is greater than the second.
     *
     * @param $item1
     * @param $item2
     *
     * @return bool
     */
    protected abstract function compare($item1, $item2): bool;
}
