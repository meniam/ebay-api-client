<?php

namespace Catalol\Histogram;

class AspectName extends Item
{
    private $values;

    public function __construct($name, array $data)
    {
        parent::__construct($name, $data);
        foreach ($data['values'] as $vName=>$value) {
            $this->values[] = new AspectValue($vName, $value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }
}