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
        $this->imageArray = $data['images'];
        $aspectArray = array();
        $this->sku = $this->generateSku($data['aspects']['original']);
        foreach ($data['aspects']['original'] as $name => $valueList) {
            $cond = new AspectCondition();
            $translationAspect = each($data['aspects']['translation']);
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

    private function generateSku($aspects)
    {
        ksort($aspects);
        $params = [];
        foreach ($aspects as $k=>$v) {
            $params[] = $k . '=' . implode('|', $v);
        }
        return md5(implode('&', $params));
    }

}