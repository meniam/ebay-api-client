<?php

namespace Catalol\Histogram;

class AspectValue extends Item
{
    private $count;

    public function __construct($name, array $data)
    {
        parent::__construct($name, $data);
        $this->count = $data['count'];
    }

    public function getCount()
    {
        return $this->count;
    }
}