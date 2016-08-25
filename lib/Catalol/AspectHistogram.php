<?php

namespace Catalol;

use Catalol\Histogram\AspectName;

class AspectHistogram
{
    private $aspects;
    private $aspectNames = [];
    private $selection = [];
    private $brands = [];
    private $brandsFull = [];
    private $brandName;

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
        $this->brandsFull = isset($data['brands_full']) ? $data['brands_full'] : [];        
        $this->brandName = isset($data['brand_field']) ? $data['brand_field'] : null;
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
    
    /**
     * @return array|mixed
     */
    public function getBrandsFull()
    {
        return $this->brandsFull;
    }    

    public function getBrandName()
    {
        return $this->brandName;
    }
}
