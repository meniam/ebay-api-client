<?php
namespace Catalol;

class Price
{
    private $value;

    private $currency;

    public function __construct($value = null, $currency = null)
    {
        $this->currency = $currency;
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float|null
     */
    public function getValue()
    {
        return $this->value;
    }


}