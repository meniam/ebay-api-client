<?php

namespace Catalol;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s';

    private $httpClient;
    private $key;
    private $domain;

    public function __construct(\Buzz\Browser $httpClient, $domain, $key)
    {
        $this->httpClient = $httpClient;
        $this->key = $key;
        $this->key = $domain;
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
            throw new Exception\BadResponse;
        }
        return $content;
    }
}