<?php
namespace Catalol;

class Aspect
{
    private $name;
    private $valueArray;
    private $translationName;
    private $translationValueArray;

    public function __construct(AspectCondition $condition)
    {
        $this->name = $condition->getName();
        $this->valueArray = $condition->getValueList();
        $this->translationName = $condition->getTranslationName();
        $this->translationValueArray = $condition->getTranslationValueList();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getTranslationName()
    {
        return $this->translationName;
    }

    /**
     * @return array
     */
    public function getValueArray()
    {
        return $this->valueArray;
    }

    public function getTranslationValueArray()
    {
        return $this->translationValueArray;
    }


}