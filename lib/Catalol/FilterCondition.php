<?php
namespace Catalol;

class FilterCondition
{
    const SITE_ID_USA = 'US';
    const SITE_ID_UK = 'UK';
    const SITE_ID_DE = 'DE';
    const SITE_ID_MOTORS = 'MOTORS';
    const USA = 'US';
    const UK = 'UK';
    const DE = 'DE';
    const MOTORS = 'MOTORS';
    const PRICE_DESC = 'PRICE_DESC';
    const PRICE_ASC = 'PRICE_ASC';
    const EXPIRE_TIME_DESC = 'EXPIRE_TIME_DESC';
    const EXPIRE_TIME_ASC = 'EXPIRE_TIME_ASC';
    const ADD_TIME_ASC = 'ADD_TIME_ASC';
    const ADD_TIME_DESC = 'ADD_TIME_DESC';
    const MODIFY_TIME_DESC = 'MODIFY_TIME_DESC';
    const MODIFY_TIME_ASC = 'MODIFY_TIME_ASC';


    /**
     * @deprecated
     */
    private $no_variations;

    private $category_id;
    private $country;
    private $min_price;
    private $max_price;
    private $condition_id;
    private $auction;
    private $start;
    private $limit;
    private $min_time;
    private $max_time;
    private $site_id;
    private $min_amount;
    private $max_amount;
    private $product_info;
    private $seller_name;
    private $sort;
    private $exact_phrase;

    public function __construct()
    {
        $this->min_time = time();
    }

    /**
     * @deprecated SHOULD NOT affect search results
     *
     * This function will be removed in the next version
     */
    public function withoutVariations()
    {
        $this->no_variations = 'true';
        return $this;
    }

    public function priceWithIn($minPrice = null, $maxPrice = null)
    {
        $this->min_price = $minPrice;
        $this->max_price = $maxPrice;
        return $this;
    }

    public function start($start = 0)
    {
        $this->start = $start;
        return $this;
    }

    public function limit($limit = 50)
    {
        $this->limit = $limit;
        return $this;
    }

    public function onlyNew()
    {
        $this->condition_id = implode('|', array(1000, 1500, 1750));
        return $this;
    }

    public function onlySalvage()
    {
        $this->condition_id = implode('|', array(2000, 2500, 3000, 4000, 5000, 6000, 7000));
        return $this;
    }

    public function byCategory($id, $country = self::USA)
    {
        $this->category_id = $id;
        $this->country = $country;
        return $this;
    }

    public function onlyUndefined()
    {
        $this->condition_id = '0';
        return $this;
    }

    /**
     * @param string
     */
    public function expiredAfter($time)
    {
        $this->max_time = $time;
        return $this;
    }

    public function productSiteId($siteId)
    {
        $this->site_id = $siteId;
        return $this;
    }

    /**
     * @param string
     */
    public function expiredBefore($time)
    {
        $this->min_time = $time;
        return $this;
    }

    public function auctionOnly()
    {
        $this->auction = 'true';
        return $this;
    }

    public function withoutAuction()
    {
        $this->auction = 'false';
        return $this;
    }

    public function minAmount($amount)
    {
        $this->min_amount = $amount;
        return $this;
    }

    public function maxAmount($amount)
    {
        $this->max_amount = $amount;
        return $this;
    }

    public function toString()
    {
        $parameters = [];
        foreach (get_object_vars($this) as $key => $element) {
            if (empty($element)) {
                continue;
            }
            $parameters[$key] = $element;
        }
        return http_build_query($parameters);
    }

    public function fullInfo()
    {
        $this->product_info = 'medium';
    }

    public function sellerName($sellerName)
    {
        $this->seller_name = $sellerName;
        return $this;
    }

    public function orderBy($sort)
    {
        $this->sort = $sort;
    }

    public function byExactPhrase($phrase)
    {
        $this->exact_phrase = $phrase;
        return $this;
    }
}