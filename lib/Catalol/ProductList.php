<?php
namespace Catalol;

class ProductList
{
    private $productList;

    private $total;

    public function __construct(\ArrayIterator $productList, $total)
    {
        $this->productList = $productList;
        $this->total = $total;
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


}