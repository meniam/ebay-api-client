<?php
namespace Catalol;

class ShippingCostSummary
{
    private $type;
    private $countryShippingPrice;
    private $worldShippingPrice;
    private $name;

    public function __construct($data)
    {
        $this->type = $data['type'];
        $this->countryShippingPrice = new Price($data['country_shipping_price']['price'], $data['country_shipping_price']['currency']);
        $this->worldShippingPrice = new Price(
            $data['world_shipping_price']['price'], $data['world_shipping_price']['currency']
        );
        $this->name = $data['name'];
    }

    /**
     * @deprecated
     * @see getWorldShippingPrice()
     * @return Price
     */
    public function getListedShippingService()
    {
        return $this->getWorldShippingPrice();
    }

    /**
     * @return Price
     */
    public function getWorldShippingPrice()
    {
        return $this->worldShippingPrice;
    }

    /**
     * @deprecated
     * @see getCountryShippingPrice()
     * @return Price
     */
    public function getShippingService()
    {
        $this->getCountryShippingPrice();
    }

    /**
     * @return Price
     */
    public function getCountryShippingPrice()
    {
        return $this->countryShippingPrice;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}
