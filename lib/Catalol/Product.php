<?php

namespace Catalol;

class Product
{
    private $domainList = [
        'DE' => 'ebay.de',
        'UK' => 'ebay.co.uk'
    ];
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @deprecated use getCurrentPrice() instead
     * @return float
     */
    public function getPrice()
    {
        return $this->data['price'];
    }

    /**
     * @return Price
     */
    public function getCurrentPrice()
    {
        return new Price($this->data['price'], $this->data['currency']);
    }

    /**
     * @return int
     */
    public function getHitCountEbay()
    {
        return $this->data['ebay_hits'];
    }


    /**
     * @deprecated use getCurrentPrice() instead
     * @return string
     */
    public function getCurrency()
    {
        return $this->data['currency'];
    }

    /**
     * @deprecated
     * @see getAspects
     */
    public function getAspectList()
    {
        return $this->getAspects();
    }

    /**
     * @return \ArrayIterator|Aspect[]
     */
    public function getAspects()
    {
        if (!$this->data['aspects']) {
            return new \ArrayIterator([]);
        }
        $aspects = [];
        $translatedKeys = array_combine(array_keys($this->data['aspects']['original']),
            array_keys($this->data['aspects']['translation']));
        foreach ($translatedKeys as $name=>$translatedName) {
            $cond = new AspectCondition();
            $cond->setName($name)
                ->setValueList($this->data['aspects']['original'][$name])
                ->setTranslationName($translatedName)
                ->setTranslationValueList($this->data['aspects']['translation'][$translatedName]);
            $aspects[] = new Aspect($cond);
        }
        return new \ArrayIterator($aspects);
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->data['amount'];
    }

    /**
     * @deprecated
     * @see getShippingCost()
     * @return ShippingCostSummary
     */
    public function getShippingCostSummary()
    {
        return $this->getShippingCost();
    }

    public function getShippingCost()
    {
        return new ShippingCostSummary($this->data['shipping_cost']);
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
        return $this->data['condition_id'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    public function getUrlBySiteId()
    {
        if (!array_key_exists($this->getSiteId(), $this->domainList)) {
            return $this->getUrl();
        }
        return preg_replace("#ebay\.com#i", $this->domainList[$this->getSiteId()], $this->getUrl());
    }

    /**
     * @return string
     */
    public function getTextDescription()
    {
        if (!array_key_exists('text_description', $this->data)) {
            return null;
        }
        return $this->data['text_description'];
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
        return $this->data['default_images'][0];
    }

    /**
     * @return array[string]
     */
    public function getImagesUrls()
    {
        return $this->data['default_images'];
    }

    /**
     * @return bool
     */
    public function isAuction()
    {
        return $this->data['is_auction'];
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
        return $this->data['original_id'];
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->data['link'];
    }

    /**
     * @return array[int]
     */
    public function getCategoriesIds()
    {
        return $this->data['categories'];
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
        return reset($this->data['categories']);
    }


    /**
     * @return array[string]
     */
    public function getPaymentMethods()
    {
        return $this->data['payment_methods'];
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->data['country'];
    }

    /**
     * @deprecated
     * @see Product::getLocation
     * @return string
     */
    public function getLocated()
    {
        return $this->getLocation();
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->data['location'];
    }

    /**
     * @return int
     */
    public function getBidCountEbay()
    {
        return $this->data['bid_count'];
    }

    /**
     * @return Price
     */
    public function getFixedPriceForAuction()
    {
        return new Price($this->data['fixed_price']['value'], $this->data['fixed_price']['currency']);
    }

    /**
     * @return bool
     */
    public function hasFixedPrice()
    {
        return $this->data['is_auction'] && !empty($this->data['fixed_price']['value']);
    }

    /**
     * @return Price
     */
    public function getMinimumToBid()
    {
        return new Price($this->data['minimum_to_bid']['value'], $this->data['minimum_to_bid']['currency']);
    }

    public function getSimilars()
    {
        if (!isset($this->data['similar'])) {
            return new \ArrayIterator();
        }
        return new \ArrayIterator($this->data['similar']);
    }

}