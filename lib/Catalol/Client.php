<?php

namespace Catalol;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s';
    const EBAY_SEARCH_URL = 'http://%s/ebay/search?key=%s';

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
        $url = $url . '&' . $filter->toString();
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
}