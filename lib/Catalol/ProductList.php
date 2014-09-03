<?php
namespace Catalol;

class ProductList
{
    private $productList;

    private $total;

    private $info;

    public function __construct(\ArrayIterator $productList, $total, $info)
    {
        $this->productList = $productList;
        $this->total = $total;
        $this->info = $info;
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
     * @return InfoList
     */
    public function getInfo()
    {
        return $this->info;
    }


}