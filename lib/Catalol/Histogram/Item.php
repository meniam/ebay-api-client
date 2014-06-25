<?php

namespace Catalol\Histogram;

class Item
{
    protected $name;
    protected $translation;

    public function __construct($name, array $data)
    {
        $this->name = $name;
        $this->translation = $data['translation'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTranslation()
    {
        return $this->translation;
    }
}