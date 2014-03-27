<?php

namespace Catalol;

class Variation
{
    private $price;

    private $amount;

    private $aspectList = array();

    private $imageArray;

    private $sku;

    public function __construct($data)
    {
        $this->price = new Price($data['price'], $data['currency']);
        $this->amount = $data['amount'];
        $this->imageArray = $data['image-list'];
        $this->sku = $data['sku'];
        $aspectArray = array();
        foreach ($data['aspect-list'] as $name => $valueArray) {
            $aspectArray[] = new Aspect($name, $valueArray);
        }
        $this->aspectList = new \ArrayIterator($aspectArray);
    }


    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \ArrayIterator
     */
    public function getAspectList()
    {
        return $this->aspectList;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getImageArray()
    {
        return $this->imageArray;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

}