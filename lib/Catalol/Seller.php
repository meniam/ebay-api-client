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
     * @return string
     */
    public function getRatingStar()
    {
        return $this->data['rating_star'];
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->data['score'];
    }

    /**
     * @return float
     */
    public function getPositiveFeedbackPercent()
    {
        return $this->data['positive_feedback_percent'];
    }
}