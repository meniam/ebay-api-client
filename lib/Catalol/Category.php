<?php
namespace Catalol;

class Category
{
    private $originalId;
    private  $country;

    public function __construct($categoryInfo = null)
    {
        if (!empty($categoryInfo)) {
            $this->prepare($categoryInfo);
        }
    }

    private function prepare($categoryInfo)
    {
        $this->originalId = $categoryInfo['original_id'];
        $this->country = $categoryInfo['country'];
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getOriginalId()
    {
        return $this->originalId;
    }


}