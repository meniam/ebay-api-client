<?php

namespace Catalol;

class Client
{
    const EBAY_PRODUCT_URL = 'http://catalol.requ.ru/ebay/product/%s.json?key=%s';

    private $httpClient;
    private $key;

    public function __construct(\Buzz\Browser $httpClient, $key)
    {
        $this->httpClient = $httpClient;
        $this->key = $key;
    }

    public function getEbayProduct($id)
    {
        $response = $this->httpClient->get(self::EBAY_PRODUCT_URL, $id, $this->key);
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