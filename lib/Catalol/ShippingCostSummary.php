<?php
namespace Catalol;

class ShippingCostSummary
{
    private $type;

    private $shippingService;

    private $listedShippingService;

    public function __construct($data)
    {
        $this->type = $data['type'];
        $this->shippingService = new Price($data['shippingService']['price'], $data['shippingService']['currency']);
        $this->listedShippingService = new Price(
            $data['listedShippingService']['price'], $data['listedShippingService']['currency']
        );
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


}
