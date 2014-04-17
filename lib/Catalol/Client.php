<?php

namespace Catalol;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s';
    const EBAY_SEARCH_URL = 'http://%s/ebay/search?key=%s';
    const EBAY_SIMILAR_URL = 'http://%s/ebay/product/%s/similar?key=%s';
    const EBAY_SHIPPING_URL = 'http://%s/ebay/product/%s/shipping?key=%s';

    private $httpClient;
    private $key;
    private $domain;

    public function __construct(\Buzz\Browser $httpClient, $domain, $key)
    {
        $this->httpClient = $httpClient;
        $this->key = $key;
        $this->domain = $domain;
    }

    public function getEbayProduct($id)
    {
        $url = sprintf(self::EBAY_PRODUCT_URL, $this->domain, $id, $this->key);
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new Product($content);
    }

    private function parseResponse(\Buzz\Message\MessageInterface $response)
    {
        $content = json_decode($response->getContent(), true);
        if (!$content || $content['status'] != 'ok') {
            throw new Exception\BadResponse($content['message']);
        }
        return $content;
    }

    public function find(FilterCondition $filter)
    {
        $url = sprintf(self::EBAY_SEARCH_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);

        return new ProductList(
            new \ArrayIterator(
                array_map(
                    function($elem){return new Product($elem);},
                    $content['products'])
            ),
            $content['total']
        );
    }

    public function getSimilarEbayProduct($id)
    {
        $url = sprintf(self::EBAY_SIMILAR_URL, $this->domain, $id, $this->key);
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new \ArrayIterator(
            array_map(
                function ($elem) {
                    return new Product($elem);
                },
                $content['products'])
        );
    }

    public function getShipping(Shipping $shipping)
    {
        $url = sprintf(self::EBAY_SHIPPING_URL, $this->domain, $shipping->getId(), $this->key);
        $url .= '&' . $shipping->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new ShippingCostSummary($content);
    }
}