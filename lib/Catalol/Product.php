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
     * @return int
     */
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

    /**
     * @return \ArrayIterator|Aspect[]
     */
    public function getAspectList()
    {
        $aspectArray = array();
        foreach ($this->data['aspects'] as $name => $valueArray) {
            $aspectArray[] = new Aspect($name, $valueArray);
        }
        return new \ArrayIterator($aspectArray);
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->data['amount'];
    }

    /**
     * @return ShippingCostSummary
     */
    public function getShippingCostSummary()
    {
        return new ShippingCostSummary(current($this->data['shippingCostSummary']));
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
        return new \DateTime($this->data['expire_at']);
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
        return $this->data['name'];
    }

    /**
     * @return \ArrayIterator | Variation[]
     */
    public function getVariationList()
    {
        $variationArray = array();
        foreach ($this->data['variations'] as  $variation) {
            $variationArray[] = new Variation($variation);
        }
        return new \ArrayIterator($variationArray);
    }

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
     * @return array[int]
     */
    public function getCategoriesIds()
    {
        return $this->data['categoryList'];
    }

    /**
     * @return string
     */
    public function getSiteId()
    {
        return $this->data['site_id'];
    }

    /**
     * @return int
     */
    public function getPrimaryCategoryId()
    {
        return reset($this->data['categoryList']);
    }


    /**
     * @return array[string]
     */
    public function getPaymentMethods()
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

    /**
     * @return string
     */
    public function getLocated()
    {
        return $this->data['located'];
    }

    /**
     * @return int
     */
    public function getBidCountEbay()
    {
        return $this->data['bidCount'];
    }

    /**
     * @return Price
     */
    public function getFixedPriceForAuction()
    {
        return new Price($this->data['fixedPrice']['value'], $this->data['fixedPrice']['currency']);
    }

    /**
     * @return bool
     */
    public function hasFixedPrice()
    {
        return $this->data['isAuction'] && !empty($this->data['fixedPrice']['value']);
    }

    /**
     * @return Price
     */
    public function getMinimumToBid()
    {
        return new Price($this->data['minimum_to_bid']['value'], $this->data['minimum_to_bid']['currency']);
    }

}