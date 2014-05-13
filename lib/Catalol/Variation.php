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
        foreach ($data['aspect-list']['original'] as $name => $valueList) {
            $cond = new AspectCondition();
            $translationAspect = each($data['aspect-list']['translation']);
            $cond->setName($name)
                ->setValueList($valueList)
                ->setTranslationName($translationAspect['key'])
                ->setTranslationValueList($translationAspect['value']);
            $aspectArray[] = new Aspect($cond);
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
     * @return \ArrayIterator|Aspect[]
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