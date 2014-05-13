<?php
namespace Catalol;

class Aspect
{
    private $name;

    private $valueArray;

    private $translationName;

    private $translationValueArray;

    public function __construct(AspectCondition $cond)
    {
        $this->name = $cond->getName();
        $this->valueArray = $cond->getValueList();
        $this->translationName = $cond->getTranslationName();
        $this->translationValueArray = $cond->getTranslationValueList();
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