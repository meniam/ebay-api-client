<?php

class ClientTest extends PHPUnit_Framework_TestCase
{

    public function testGetEbayProductReturnsProduct()
    {
        $response = new \Buzz\Message\Response();
        $response->setContent(file_get_contents('./tests/fixtures/product/without_variations.json'));
        $buzz = $this->getMock('Buzz\Browser');
        $buzz->expects($this->once())->method('get')->willReturn($response);
        $c = new \Catalol\Client($buzz, 'domain.com', '123');
        $this->assertInstanceOf('Catalol\Product', $c->getEbayProduct('3423423423423'));
    }

    public function testGetEbayProductReturnsFailedIfNoConnection()
    {
        $buzz = $this->getMock('Buzz\Browser');
        $buzz->expects($this->once())->method('get')->willThrowException(new Buzz\Exception\ClientException());
        $c = new \Catalol\Client($buzz, 'domain.com', '123');
        $this->setExpectedException('Catalol\Exception\ServiceIsDown', 'host is unreachable');
        $c->getEbayProduct('3423423423423');
    }

    public function testFind()
    {
        $response = new \Buzz\Message\Response();
        $response->setContent(file_get_contents('./tests/fixtures/product_list/search.json'));
        $buzz = $this->getMock('Buzz\Browser');
        $buzz->expects($this->once())->method('get')->willReturn($response);
        $c = new \Catalol\Client($buzz, 'domain.com', '123');
        $this->assertInstanceOf('Catalol\ProductList', $c->find(new \Catalol\FilterCondition()));
    }

    public function testGetSimilarEbayProduct()
    {
        $response = new \Buzz\Message\Response();
        $response->setContent(file_get_contents('./tests/fixtures/product_list/similar.json'));
        $buzz = $this->getMock('Buzz\Browser');
        $buzz->expects($this->once())->method('get')->willReturn($response);
        $c = new \Catalol\Client($buzz, 'domain.com', '123');
        $this->assertInstanceOf('ArrayIterator', $c->getSimilarEbayProduct('1342434', 5));
    }

    public function testGetShipping()
    {
        $response = new \Buzz\Message\Response();
        $response->setContent(file_get_contents('./tests/fixtures/product/shipping.json'));
        $buzz = $this->getMock('Buzz\Browser');
        $buzz->expects($this->once())->method('get')->willReturn($response);
        $c = new \Catalol\Client($buzz, 'domain.com', '123');
        $this->assertInstanceOf('Catalol\ShippingCostSummary', $c->getShipping(new \Catalol\Shipping()));
    }

}