<?php

namespace Catalol\Aspect;

class AspectValue
{
    private $value;
    private $translation;
    private $special;

    public function __construct(ValueBuilder $builder)
    {
        $this->value = $builder->getValue();
        $this->translation = $builder->getTranslation();
        $this->special = $builder->getSpecial();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function getSpecial()
    {
        return $this->special;
    }

    public function isSku()
    {
        return $this->special == 'sku';
    }

    public function isBrand()
    {
        return $this->special == 'brand';
    }

    public function isModel()
    {
        return $this->special == 'model';
    }
}