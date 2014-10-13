<?php

namespace Catalol;

use Catalol\Histogram\AspectName;

class AspectHistogram
{
    private $aspects;
    private $aspectNames = [];
    private $selection = [];

    public function __construct(array $data)
    {
        $aspects = [];
        foreach ($data['histogram'] as $aspect) {
            $aspects[] = new AspectName($aspect['name'], $aspect);
        }
        $this->aspects = new \ArrayIterator($aspects);
        $this->aspectNames = $data['other_params'];
        $this->selection = $data['selection'];
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
}