<?php
namespace Catalol;

class InfoList
{
    private $categoryInfo;
    private $brand;
    private $model;

    public function __construct($response)
    {
        if (!empty($response['info'])) {
            $this->prepare($response['info']);
        }
    }

    private function prepare($info)
    {
        $this->brand = $info['brand'];
        $this->model = $info['model'];
        $this->categoryInfo = new Category($info['category']);
    }

    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return Category
     */
    public function getCategoryInfo()
    {
        return $this->categoryInfo;
    }

    public function getModel()
    {
        return $this->model;
    }


}