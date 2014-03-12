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

    public function getPaymentMethods()
    {
        return $this->data['paymentMethods'];
    }

    public function getHitCountEbay()
    {
        return $this->data['hitCountEbay'];
    }


    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->data['currency'];
    }

    public function getAspect()
    {
        $aspectList = array();
        foreach ($this->data['aspects'] as $name => $valueArray) {
            $aspectList[] = new Aspect($name, $valueArray);
        }
        return new Collection($aspectList);
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
        return $this->data['shippingCostSummary'];
    }

    /**
     * @return string
     */
    public function getConditionName()
    {
        return $this->data['condition'];
    }

    /**
     * @return int
     */
    public function getConditionId()
    {
        return $this->data['conditionId'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return new \DateTime($this->data['expiredAt']);
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