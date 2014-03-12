<?php
namespace Catalol;

class Collection extends \ArrayIterator
{
    private $itemList = [];

    public function __construct(array $itemArray)
    {
        parent::__construct($itemArray);
        foreach ($itemArray as $item) {
            $this->itemList[] = $item;
        }
    }
}