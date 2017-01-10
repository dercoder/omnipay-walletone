<?php

namespace Omnipay\WalletOne\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'merchantId'       => 'D200001',
            'secretKey'        => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
            'algorithm'        => 'sha1',
            'amount'           => 5.24,
            'currency'         => 'EUR',
            'transactionId'    => 'TX12345',
            'description'      => 'Test Transaction',
            'returnUrl'        => 'https://www.example.com/return.html',
            'cancelUrl'        => 'https://www.example.com/cancel.html',
            'expirationDate'   => new \DateTime('2020-10-23 12:34:54', new \DateTimeZone('Europe/Paris')),
            'autoLocation'     => true,
            'enabledPayments'  => array('WebMoneyRUB', 'WebMoneyUSD'),
            'disabledPayments' => array('W1RUB')
        ));
    }

    public function testGetExpirationDate()
    {
        $this->request->setExpirationDate(null);
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getExpirationDate();
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('D200001', $data['WMI_MERCHANT_ID']);
        $this->assertSame('5.24', $data['WMI_PAYMENT_AMOUNT']);
        $this->assertSame('978', $data['WMI_CURRENCY_ID']);
        $this->assertSame('BASE64:VGVzdCBUcmFuc2FjdGlvbg==', $data['WMI_DESCRIPTION']);
        $this->assertSame('TX12345', $data['WMI_PAYMENT_NO']);
        $this->assertSame('https://www.example.com/return.html', $data['WMI_SUCCESS_URL']);
        $this->assertSame('https://www.example.com/cancel.html', $data['WMI_FAIL_URL']);
        $this->assertSame('2020-10-23T10:34:54', $data['WMI_EXPIRED_DATE']);
        $this->assertSame('1', $data['WMI_AUTO_LOCATION']);
        $this->assertSame(array('WebMoneyRUB', 'WebMoneyUSD'), $data['WMI_PTENABLED']);
        $this->assertSame(array('W1RUB'), $data['WMI_PTDISABLED']);
        $this->assertSame('0AL7EJU8RQOml5CRB6ZiFMljxgI=', $data['WMI_SIGNATURE']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\WalletOne\Message\PurchaseResponse', $response);
    }
}
