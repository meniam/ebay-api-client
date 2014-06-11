<?php

namespace Catalol;

use Catalol\Exception\ApiError;
use Catalol\Exception\BadResponse;
use Catalol\Exception\CatalolIsDown;
use Catalol\Exception\NotFound;
use Catalol\Exception\ServiceIsDown;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s&lang=%s&country=%s';
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

    public function getEbayProduct($id, $lang = 'ru', $countryShortName = 'USA')
    {
        $url = sprintf(self::EBAY_PRODUCT_URL, $this->domain, $id, $this->key, (string)$lang, $countryShortName);
        try {
            $response = $this->httpClient->get($url);
        } catch (\Buzz\Exception\ClientException $e) {
            throw new ServiceIsDown('host is unreachable');
        }
        $content = $this->parseResponse($response);
        return new Product($content);
    }

    private function parseResponse(\Buzz\Message\MessageInterface $response)
    {
        $content = json_decode($response->getContent(), true);
        if (!$content || !isset($content['status'])) {
            throw new Exception\CatalolIsDown('No status provided');
        }
        if ($content['status'] != 'ok') {
            return $this->parseBadResponse($content);
        }
        return $content;
    }

    private function parseBadResponse($content)
    {
        if (!isset($content['code'])) {
            throw new BadResponse('No error code provided');
        }
        switch ($content['code']) {
            case 'not_found':
                throw new NotFound($content['message']);
            case 'api_error':
                throw new ApiError($content['message']);
            case 'internal_error':
                throw new ServiceIsDown($content['message']);
            default:
                throw new BadResponse($content['message']);
        }
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