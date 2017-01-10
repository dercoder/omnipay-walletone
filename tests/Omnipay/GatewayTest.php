<?php

namespace Omnipay\WalletOne;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('D200001');
        $this->gateway->setSecretKey('B8AKTPWBRMNBV455FG6M2DANE99WU2');
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertSame('D200001', $request->getMerchantId());
        $this->assertSame('B8AKTPWBRMNBV455FG6M2DANE99WU2', $request->getSecretKey());
        $this->assertSame('md5', $request->getAlgorithm());
        $this->assertInstanceOf('Omnipay\WalletOne\Message\PurchaseRequest', $request);
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf('Omnipay\WalletOne\Message\CompletePurchaseRequest', $request);
    }
}
