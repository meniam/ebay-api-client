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
        return $this->data['ebay_hits'];
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
        if (!$this->data['aspects']) {
            return new \ArrayIterator([]);
        }
        $aspects = [];
        foreach ($this->data['aspects']['original'] as $name => $valueList) {
            $translatedAspect = each($this->data['aspects']['translation']);
            $cond = new AspectCondition();
            $cond->setName($name)
                ->setValueList($valueList)
                ->setTranslationName($translatedAspect['key'])
                ->setTranslationValueList($translatedAspect['value']);
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
     * @return ShippingCostSummary
     */
    public function getShippingCostSummary()
    {
        return new ShippingCostSummary(current($this->data['shipping_cost']));
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
     * @return string
     */
    public function getLocated()
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

}