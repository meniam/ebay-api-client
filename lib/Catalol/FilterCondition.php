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

    private $params = [];

    public function priceWithin($minPrice = null, $maxPrice = null)
    {
        $this->params['min_price'] = $minPrice;
        $this->params['max_price'] = $maxPrice;
        return $this;
    }

    public function start($start = 0)
    {
        $this->params['start'] = $start;
        return $this;
    }

    public function limit($limit = 50)
    {
        $this->params['limit'] = $limit;
        return $this;
    }

    public function onlyNew()
    {
        $this->params['condition_id'] = implode('|', array(1000, 1500, 1750));
        return $this;
    }

    public function onlySalvage()
    {
        $this->params['condition_id'] = implode('|', array(2000, 2500, 3000, 4000, 5000, 6000, 7000));
        return $this;
    }

    public function byCategory($id, $country = self::USA)
    {
        $this->params['category_id'] = $id;
        $this->params['country'] = $country;
        return $this;
    }

    public function onlyUndefined()
    {
        $this->params['condition_id'] = '0';
        return $this;
    }

    /**
     * @param string
     */
    public function expiredAfter($time)
    {
        $this->params['max_time'] = $time;
        return $this;
    }

    /**
     * @param string
     */
    public function expiredBefore($time)
    {
        $this->params['min_time'] = $time;
        return $this;
    }

    public function productSiteId($siteId)
    {
        $this->params['site_id'] = $siteId;
        return $this;
    }

    public function auctionOnly()
    {
        $this->params['auction'] = 'true';
        return $this;
    }

    public function withoutAuction()
    {
        $this->params['auction'] = 'false';
        return $this;
    }

    /**
     * @deprecated
     */
    public function minAmount($amount)
    {
        $this->params['min_amount'] = $amount;
        return $this;
    }

    /**
     * @deprecated
     */
    public function maxAmount($amount)
    {
        $this->params['max_amount'] = $amount;
        return $this;
    }

    public function toString()
    {
        return http_build_query($this->params);
    }

    public function fullInfo()
    {
        $this->params['product_info'] = 'medium';
        return $this;
    }

    public function sellerName($sellerName)
    {
        $this->params['seller_name'] = $sellerName;
        return $this;
    }

    public function orderBy($sort)
    {
        $this->params['sort'] = $sort;
        return $this;
    }

    public function byExactPhrase($phrase)
    {
        $this->params['exact_phrase'] = $phrase;
        return $this;
    }
}
