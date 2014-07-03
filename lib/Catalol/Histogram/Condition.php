<?php

namespace Catalol\Histogram;

class Condition
{
    private $id;
    private $count;

    public function __construct($id, $count)
    {
        $this->id = $id;
        $this->count = $count;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCount()
    {
        return $this->count;
    }
}