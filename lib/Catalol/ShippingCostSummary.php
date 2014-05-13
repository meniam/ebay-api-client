<?php
namespace Catalol;

class ShippingCostSummary
{
    private $type;

    private $shippingService;

    private $listedShippingService;

    private $name;

    public function __construct($data)
    {
        $this->type = $data['type'];
        $this->shippingService = new Price($data['country_shipping_price']['price'], $data['country_shipping_price']['currency']);
        $this->listedShippingService = new Price(
            $data['world_shipping_price']['price'], $data['world_shipping_price']['currency']
        );
        $this->name = $data['name'];
    }

    /**
     * @return Price
     */
    public function getListedShippingService()
    {
        return $this->listedShippingService;
    }

    /**
     * @return Price
     */
    public function getShippingService()
    {
        return $this->shippingService;
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
