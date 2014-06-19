<?php

class FilterConditionTest extends PHPUnit_Framework_TestCase
{
    private $subject;

    protected function setUp()
    {
        $this->subject = new \Catalol\FilterCondition();
    }

    public function testPriceWithin()
    {
        $this->subject->priceWithin(10, 20);
        $this->assertEquals('min_price=10&max_price=20', $this->subject->toString());
    }

    public function testStart()
    {
        $this->subject->start(10);
        $this->assertEquals('start=10', $this->subject->toString());
    }

    public function testLimit()
    {
        $this->subject->limit(5);
        $this->assertEquals('limit=5', $this->subject->toString());
    }

    public function testOnlyNew()
    {
        $this->subject->onlyNew();
        $this->assertEquals('condition_id=1000%7C1500%7C1750', $this->subject->toString());
    }

    public function testOnlySalvage()
    {
        $this->subject->onlySalvage();
        $this->assertEquals('condition_id=2000%7C2500%7C3000%7C4000%7C5000%7C6000%7C7000',
            $this->subject->toString());
    }

    public function testByCategory()
    {
        $this->subject->byCategory(6028, 'MOTORS');
        $this->assertEquals('category_id=6028&country=MOTORS', $this->subject->toString());
    }

    public function testExpiredAfter()
    {
        $this->subject->expiredAfter(1111);
        $this->assertEquals('max_time=1111', $this->subject->toString());
    }

    public function testExpiredBefore()
    {
        $this->subject->expiredBefore(1111);
        $this->assertEquals('min_time=1111', $this->subject->toString());
    }

    public function testProductSiteId()
    {
        $this->subject->productSiteId(100);
        $this->assertEquals('site_id=100', $this->subject->toString());
    }

    public function testAuctionOnly()
    {
        $this->subject->auctionOnly();
        $this->assertEquals('auction=true', $this->subject->toString());
    }

    public function testWithoutAuction()
    {
        $this->subject->withoutAuction();
        $this->assertEquals('auction=false', $this->subject->toString());
    }

    public function testFullInfo()
    {
        $this->subject->fullInfo();
        $this->assertEquals('product_info=medium', $this->subject->toString());
    }

    public function testSellerName()
    {
        $this->subject->sellerName('adoramacamera');
        $this->assertEquals('seller_name=adoramacamera', $this->subject->toString());
    }

    public function testOrderBy()
    {
        $this->subject->orderBy('PRICE_DESC');
        $this->assertEquals('sort=PRICE_DESC', $this->subject->toString());
    }

    public function testByExactPhrase()
    {
        $this->subject->byExactPhrase('iPhone 9S');
        $this->assertEquals('exact_phrase=iPhone+9S', $this->subject->toString());
    }
}