<?php

namespace Catalol;

use Catalol\Histogram\AspectName;

class AspectHistogram
{
    private $aspects;
    private $aspectNames = [];
    private $selection = [];
    private $brands = [];

    public function __construct(array $data)
    {
        $aspects = [];
        foreach ($data['histogram'] as $aspect) {
            $aspects[] = new AspectName($aspect['name'], $aspect);
        }
        $this->aspects = new \ArrayIterator($aspects);
        $this->aspectNames = $data['other_params'];
        $this->selection = $data['selection'];
        $this->brands = $data['brands'];
    }

    public function getAspects()
    {
        return $this->aspects;
    }

    public function getRestAspectNames()
    {
        return $this->aspectNames;
    }

    public function getSelection()
    {
        return $this->selection;
    }

    public function getBrands()
    {
        return $this->brands;
    }
}