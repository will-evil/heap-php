# Heap

Class for creating min heap, max heap. Implementing a priority queue, heap sorting e.t.c.
I know about classes SplHeap, SplMaxHeap, SplMinHeap e.t.c but I did it to practice.

## Methods

##### Constructor
````
__construct(array $arr = [], bool $maxHeap = true)

$arr - Array to create a heap.
$maxHeap - Heap type. If true will be create max heap.
````
##### Heap count
````
int count()
````
##### Insert item to heap
````
bool insert(mixed $item)
````
##### Get root item value
````
mixed top()
````
##### Extract top item
````
mixed extractTop()
````
##### Extract item by index
````
mixed extract(int $index)
````
##### Sort DESC or ASC. If create max heap will do DESC sort.
````
array sort()
````
##### To array
````
array toArray()
````
#### Is empty
````
bool isEmpty()
````

