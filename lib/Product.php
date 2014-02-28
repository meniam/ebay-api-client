<?php

namespace Catalol;

class Product
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->data['price'];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->data['currency'];
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->data['amount'];
    }

    /**
     * @return float
     */
    public function getShippingCost()
    {
        return $this->data['shipping_cost'];
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->data['condition'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * @return DateTime
     */
    public function getExpirationDate()
    {
        return new DateTime($this->data['expiredAt']);
    }

    /**
     * @return string
     */
    public function getMainImageUrl()
    {
        return $this->data['imageDefault'][0];
    }

    /**
     * @return array[string]
     */
    public function getImagesUrls()
    {
        return $this->data['imageDefault'];
    }

    /**
     * @return bool
     */
    public function isAuction()
    {
        return $this->data['isAuction'];
    }

    /**
     * @return Seller
     */
    public function getSeller()
    {
        return new Seller($this->data['seller']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return new $this->data['name'];
    }

    public function getVariation()
    {}

    /**
     * @return string
     */
    public function getId()
    {
        return $this->data['originalId'];
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->data['originalLink'];
    }

    /**
     * @return array[string]
     */
    public function getCategories()
    {
        return $this->data['categoryList'];
    }

    /**
     * @return array[string]
     */
    public function getAvailablePaymentMethods()
    {
        return $this->data['paymentMethod'];
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->data['country'];
    }
}