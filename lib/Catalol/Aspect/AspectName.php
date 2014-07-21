<?php

namespace Catalol\Aspect;

class AspectName
{
    private $name;
    private $translation;
    private $values;

    public function __construct(NameBuilder $builder)
    {
        $this->name = $builder->getName();
        $this->translation = $builder->getTranslation();
        $this->values = $builder->getValues();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function getValues()
    {
        return $this->values;
    }
}