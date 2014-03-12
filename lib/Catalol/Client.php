<?php

namespace Catalol;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $serialize = new Serializer(array(new GetSetMethodNormalizer()), array(new XmlEncoder(), new JsonEncoder()));
        $content = $serialize->decode($response->getContent(), 'json');
        if (!$content || $content['status'] != 'ok') {
            throw new Exception\BadResponse($content['message']);
        }
        return $content;
    }
}