<?php
namespace Catalol;

class Shipping
{
    private $id;

    private $amount;

    private $country;

    private $postal_code;


    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }


    public function setCountryShortName($country)
    {
        $this->country = $country;
        return $this;
    }


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }


    public function toString()
    {
        $parameters = [];
        foreach (get_object_vars($this) as $key => $element) {
            if (empty($element) || $key == 'id') {
                continue;
            }
            $parameters[$key] = $element;
        }
        return http_build_query($parameters);
    }

    public function getId()
    {
        return $this->id;
    }



}