<?php
namespace Catalol;

class FilterCondition
{
    private $no_variations;

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


    public function withOutVariations()
    {
        $this->no_variations = 'true';
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

    /**
     * @param string
     * @value new|salvage|undefined
     */
    public function condition($condition)
    {
        switch (mb_strtolower($condition)) {
            case ('new') :
                $this->condition_id = implode('|', array(1000, 1500, 1750));
                break;
            case ('salvage') :
                $this->condition_id = implode('|', array(2000, 2500, 3000, 4000, 5000, 6000, 7000));
                break;
            case ('undefined') :
                $this->condition_id = '0';
                break;
        }
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

    public function withOutAuction()
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

    public function productSiteId($siteId)
    {
        $this->site_id = $siteId;
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
}