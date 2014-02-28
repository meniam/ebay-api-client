<?php

namespace Catalol;

class Seller
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->data['feedbackScore'];
    }

    /**
     * @return float
     */
    public function getPositiveFeedbackPercent()
    {
        return $this->data['positiveFeedbackPercent'];
    }
}