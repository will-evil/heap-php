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

        return $this->extract(key($this->heap));
    }

    /**
     * @param int $index
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function extract(int $index)
    {
        $index = $this->shiftDown($index);

        $value = $this->heap[$index];

        $rightIndex = $this->moveToRightPosition($index);
        unset($this->heap[$rightIndex]);

        return $value;
    }

    /**
     * @return array
     */
    public function sort(): array
    {
        $sortArr = [];
        $copyHeap = $this->heap;

        try {
            while (false === $this->isEmpty()) {
                $sortArr[] = $this->extractTop();
            }
        } catch (\Exception $e) {
            $sortArr = [];
        }

        $this->heap = $copyHeap;

        return $sortArr;
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
     *
     * @throws \Exception
     */
    private function getParentIndex(int $childIndex): int
    {
        $this->checkIndexExistence($childIndex);

        if (0 === $childIndex) {
            return 0;
        }

        return (int) floor(($childIndex - 1) / 2);
    }

    /**
     * @param int $parentIndex
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getChildrenIndexes(int $parentIndex): array
    {
        $this->checkIndexExistence($parentIndex);

        $product = 2 * $parentIndex;
        $indexLeft = $product + 1;
        $indexRight = $product + 2;

        $indexLeft = isset($this->heap[$indexLeft]) ? $indexLeft : 0;
        $indexRight = isset($this->heap[$indexRight]) ? $indexRight : 0;

        return [
            $indexLeft,
            $indexRight,
        ];
    }

    /**
     * @param int $parentIndex
     *
     * @return int
     *
     * @throws \Exception
     */
    private function getBestChildIndex(int $parentIndex): int
    {
        list($indexLeft, $indexRight) = $this->getChildrenIndexes($parentIndex);

        if (0 === $indexLeft && 0 === $indexRight) {
            return 0;
        }

        if (0 === $indexLeft || 0 === $indexRight) {
            return $indexLeft !== 0 ? $indexLeft : $indexRight;
        }

        $leftVal = $this->heap[$indexLeft];
        $rightVal = $this->heap[$indexRight];

        $res = $this->compare($leftVal, $rightVal);
        $res = true === $this->maxHeap ? $res : !$res;

        return $res ? $indexLeft : $indexRight;
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
     * @param int $index
     *
     * @return int
     *
     * @throws \Exception
     */
    private function moveToRightPosition(int $index): int
    {
        $this->checkIndexExistence($index);

        $rightIndex = $this->count() - 1;

        if ($index !== $rightIndex) {
            $this->swap($index, $rightIndex);
            $this->shiftUp($index);
        }

        return $rightIndex;
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
     * @throws \Exception
     */
    private function checkEmpty()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Heap is empty');
        }
    }

    /**
     * @param int $index
     *
     * @throws \Exception
     */
    private function checkIndexExistence(int $index)
    {
        if (!isset($this->heap[$index])) {
            throw new \Exception('Index ' . $index . ' not exists in heap');
        }
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
