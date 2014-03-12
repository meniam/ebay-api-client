<?php
namespace Catalol;

class Aspect
{
    private $name;

    private $valueArray;

    public function __construct($name, $valueArray)
    {
        $this->name = $name;
        $this->valueArray = $valueArray;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValueArray()
    {
        return $this->valueArray;
    }


}