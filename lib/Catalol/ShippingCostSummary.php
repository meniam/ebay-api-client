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
        $this->shippingService = new Price($data['shippingService']['price'], $data['shippingService']['currency']);
        $this->listedShippingService = new Price(
            $data['listedShippingService']['price'], $data['listedShippingService']['currency']
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
