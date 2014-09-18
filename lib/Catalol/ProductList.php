<?php
namespace Catalol;

class ProductList
{
    private $productList;
    private $total;
    private $info;
    private $brands;

    public function __construct(array $content)
    {
        $this->productList = new \ArrayIterator(
            array_map(
                function($elem){return new Product($elem);},
                $content['products'])
        );
        $this->total = $content['total'];
        $this->info = new InfoList($content);
        $this->brands = $content['brands'];
    }

    /**
     * @return \ArrayIterator
     */
    public function getProductList()
    {
        return $this->productList;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @deprecated
     * @return InfoList
     */
    public function getInfo()
    {
        return $this->info;
    }

    public function getBrands()
    {
        return $this->brands;
    }

}