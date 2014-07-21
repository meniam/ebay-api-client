<?php

namespace Catalol\Aspect;

class NameBuilder
{
    private $name;
    private $translation;
    private $values;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTranslation($translation)
    {
        $this->translation = $translation;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }
}