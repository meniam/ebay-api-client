<?php
namespace Catalol;

class AspectCondition
{
    private $name;

    private $translationName;

    private $valueList;

    private $translationValueList;


    public function setTranslationName($translationName)
    {
        $this->translationName = $translationName;
        return $this;
    }


    public function getTranslationName()
    {
        return $this->translationName;
    }

    public function setTranslationValueList($translationValueList)
    {
        $this->translationValueList = $translationValueList;
        return $this;
    }

    public function getTranslationValueList()
    {
        return $this->translationValueList;
    }


    public function setValueList($valueList)
    {
        $this->valueList = $valueList;
        return $this;
    }

    public function getValueList()
    {
        return $this->valueList;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }


}