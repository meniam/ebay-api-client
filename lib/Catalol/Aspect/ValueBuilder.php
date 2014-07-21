<?php

namespace Catalol\Aspect;

class ValueBuilder
{
    private $value;
    private $translation;
    private $special;

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setTranslation($translation)
    {
        $this->translation = $translation;
    }

    public function getTranslation()
    {
        return $this->translation;
    }

    public function setSpecial($special)
    {
        $this->special = $special;
    }

    public function getSpecial()
    {
        return $this->special;
    }
}