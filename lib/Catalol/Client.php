<?php

namespace Catalol;

use Catalol\Exception\ApiError;
use Catalol\Exception\BadResponse;
use Catalol\Exception\NotFound;
use Catalol\Exception\ServiceIsDown;
use Catalol\Histogram\AspectName;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s&lang=%s&country=%s';
    const EBAY_SEARCH_URL = 'http://%s/ebay/search?key=%s';
    const EBAY_SIMILAR_URL = 'http://%s/ebay/product/%s/similar?key=%s';
    const EBAY_SHIPPING_URL = 'http://%s/ebay/product/%s/shipping?key=%s';
    const EBAY_PRODUCT_WITH_SIMILAR_URL = 'http://%s/ebay/product/%s/with-similar?key=%s&lang=%s&country=%s';
    const HISTOGRAM_URL = 'http://%s/ebay/category/%s/%s?key=%s&lang=%s';

    private $httpClient;
    private $key;
    private $domain;
    private $translationLang = 'ru';

    public function __construct(\Buzz\Browser $httpClient, $domain, $key)
    {
        $this->httpClient = $httpClient;
        $this->key = $key;
        $this->domain = $domain;
    }

    public function setTranslationLang($lang)
    {
        $this->translationLang = strval($lang);
    }

    public function getEbayProduct($id, $country = 'US')
    {
        $url = sprintf(self::EBAY_PRODUCT_URL,
            $this->domain, $id, $this->key, $this->translationLang, $country);
        try {
            $response = $this->httpClient->get($url);
        } catch (\Buzz\Exception\ClientException $e) {
            throw new ServiceIsDown('host is unreachable');
        }
        $content = $this->parseResponse($response);
        return new Product($content);
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

    public function getCategoryHistogram($categoryId, $country)
    {
        $url = sprintf(self::HISTOGRAM_URL, $this->domain, $country, $categoryId,
            $this->key, $this->translationLang);
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        $result = [];
        foreach ($content['histogram'] as $name=>$aspect) {
            $result[] = new AspectName($name, $aspect);
        }
        return $result;
    }

    public function getSimilarEbayProduct($id, $count = 5)
    {
        $url = sprintf(self::EBAY_SIMILAR_URL, $this->domain, $id, $this->key);
        $response = $this->httpClient->get($url . '&count=' . $count);
        $content = $this->parseResponse($response);
        return new \ArrayIterator(
            array_map(
                function ($elem) {
                    return new Product($elem);
                },
                $content['products'])
        );
    }

    public function getEbayProductWithSimilars($id, $count = 5, $country = 'US')
    {
        $url = sprintf(self::EBAY_PRODUCT_WITH_SIMILAR_URL,
                $this->domain, $id, $this->key, $this->translationLang, $country);
        try {
            $response = $this->httpClient->get($url . '&count=' . $count);
        } catch (\Buzz\Exception\ClientException $e) {
            throw new ServiceIsDown('host is unreachable');
        }
        $content = $this->parseResponse($response);
        return new Product($content);
    }

    public function getShipping(Shipping $shipping)
    {
        $url = sprintf(self::EBAY_SHIPPING_URL, $this->domain, $shipping->getId(), $this->key);
        $url .= '&' . $shipping->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new ShippingCostSummary($content);
    }

    private function parseResponse(\Buzz\Message\MessageInterface $response)
    {
        $content = json_decode($response->getContent(), true);
        if (!$content || !isset($content['status'])) {
            throw new Exception\ServiceIsDown('No status provided');
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
}
