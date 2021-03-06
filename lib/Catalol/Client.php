<?php

namespace Catalol;

use Catalol\Exception\ApiError;
use Catalol\Exception\BadResponse;
use Catalol\Exception\NotFound;
use Catalol\Exception\ServiceIsDown;

class Client
{
    const EBAY_PRODUCT_URL = 'http://%s/ebay/product/%s.json?key=%s&lang=%s&country=%s';
    const EBAY_PRODUCT_URL_NO_CACHE = 'http://%s/ebay/product/%s/no-cache.json?key=%s&lang=%s&country=%s';
    const EBAY_SEARCH_URL = 'http://%s/ebay/search?key=%s';
    const EBAY_DIRECT_SEARCH_URL = 'http://%s/ebay/direct-search?key=%s';
    const EBAY_API_DIRECT_SEARCH_URL = 'http://%s/ebay-api/direct-search?key=%s';
    const EBAY_SIMILAR_URL = 'http://%s/ebay/product/%s/similar?key=%s';
    const EBAY_SHIPPING_URL = 'http://%s/ebay/product/%s/shipping?key=%s';
    const EBAY_API_EBAY_SHIPPING_URL = 'http://%s/ebay-api/product/%s/shipping?key=%s';
    const EBAY_PRODUCT_WITH_SIMILAR_URL = 'http://%s/ebay/product/%s/with-similar?key=%s&lang=%s&country=%s';
    const EBAY_API_EBAY_PRODUCT_WITH_SIMILAR_URL = 'http://%s/ebay-api/product/%s/with-similar?key=%s&lang=%s&country=%s';
    const ASPECT_HISTOGRAM_URL = 'http://%s/ebay/direct-aspects?key=%s';
    const EBAY_API_ASPECT_HISTOGRAM_URL = 'http://%s/ebay-api/direct-aspects?key=%s';
    const CATEGORY_HISTOGRAM_URL = 'http://%s/ebay/category-histogram?key=%s';
    const EBAY_API_CATEGORY_HISTOGRAM_URL = 'http://%s/ebay-api/category-histogram?key=%s';
    const AMAZON_SEARCH_URL = 'http://%s/amazon/search?key=%s';

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

    public function getEbayProductWithoutCache($id, $country = 'US')
    {
        $url = sprintf(self::EBAY_PRODUCT_URL_NO_CACHE,
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
        return new ProductList($content);
    }

    public function findDirect(FilterCondition $filter)
    {
        $url = sprintf(self::EBAY_DIRECT_SEARCH_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new ProductList($content);
    }


    public function ebayApiFindDirect(FilterCondition $filter)
    {
        $url = sprintf(self::EBAY_API_DIRECT_SEARCH_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new ProductList($content);
    }

    public function amazonFind(FilterCondition $filter)
    {
        $url = sprintf(self::AMAZON_SEARCH_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new ProductList($content);
    }

    public function getAspectHistogramDirect(FilterCondition $filter, $maxAspectsCount = 3, $maxValuesCount = 6)
    {
        $url = sprintf(self::ASPECT_HISTOGRAM_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString() . '&aspect_count=' . $maxAspectsCount .
            '&value_count=' . $maxValuesCount;
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new AspectHistogram($content);
    }

    public function getPartOfAspectHistogram(FilterCondition $filter, $aspectName)
    {
        $url = sprintf(self::ASPECT_HISTOGRAM_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString() . '&only=' . urlencode($aspectName);
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new AspectHistogram($content);
    }

    public function ebayApiGetAspectHistogramDirect(FilterCondition $filter, $maxAspectsCount = 3, $maxValuesCount = 6)
    {
        $url = sprintf(self::EBAY_API_ASPECT_HISTOGRAM_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString() . '&aspect_count=' . $maxAspectsCount .
            '&value_count=' . $maxValuesCount;
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new AspectHistogram($content);
    }

    public function ebayApiGetPartOfAspectHistogram(FilterCondition $filter, $aspectName)
    {
        $url = sprintf(self::EBAY_API_ASPECT_HISTOGRAM_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString() . '&only=' . urlencode($aspectName);
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return new AspectHistogram($content);
    }

    public function getCategoryHistogramDirect(FilterCondition $filter)
    {
        $url = sprintf(self::EBAY_API_CATEGORY_HISTOGRAM_URL, $this->domain, $this->key);
        $url .= '&' . $filter->toString();
        $response = $this->httpClient->get($url);
        $content = $this->parseResponse($response);
        return $content;
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


    public function ebayApiGetEbayProductWithSimilars($id, $count = 5, $country = 'US')
    {
        $url = sprintf(self::EBAY_API_EBAY_PRODUCT_WITH_SIMILAR_URL,
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


    public function ebayApiGetShipping(Shipping $shipping)
    {
        $url = sprintf(self::EBAY_API_EBAY_SHIPPING_URL, $this->domain, $shipping->getId(), $this->key);
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
