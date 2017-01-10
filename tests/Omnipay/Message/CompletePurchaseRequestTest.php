<?php

namespace Omnipay\WalletOne\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest(array(), array(
            'WMI_MERCHANT_ID'       => 'D200001',
            'WMI_PAYMENT_AMOUNT'    => '5.23',
            'WMI_COMMISSION_AMOUNT' => '0.32',
            'WMI_CURRENCY_ID'       => '978',
            'WMI_TO_USER_ID'        => '123456789012',
            'WMI_PAYMENT_NO'        => 'TX123412',
            'WMI_ORDER_ID'          => 'TX542312',
            'WMI_DESCRIPTION'       => 'Test Transaction',
            'WMI_SUCCESS_URL'       => 'https://www.example.com/return.html',
            'WMI_FAIL_URL'          => 'https://www.example.com/cancel.html',
            'WMI_EXPIRED_DATE'      => '2020-01-21T12:43:08',
            'WMI_CREATE_DATE'       => '2020-01-01T12:43:08',
            'WMI_UPDATE_DATE'       => '2020-01-01T12:43:28',
            'WMI_ORDER_STATE'       => 'ACCEPTED',
            'WMI_SIGNATURE'         => 'X4lGf1Md2ldTTD6wz5zElg==',
        ));

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize(array(
            'merchantId' => 'D200001',
            'secretKey'  => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
            'algorithm'  => 'md5'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame(array(
            'WMI_MERCHANT_ID'       => 'D200001',
            'WMI_PAYMENT_AMOUNT'    => '5.23',
            'WMI_COMMISSION_AMOUNT' => '0.32',
            'WMI_CURRENCY_ID'       => '978',
            'WMI_TO_USER_ID'        => '123456789012',
            'WMI_PAYMENT_NO'        => 'TX123412',
            'WMI_ORDER_ID'          => 'TX542312',
            'WMI_DESCRIPTION'       => 'Test Transaction',
            'WMI_SUCCESS_URL'       => 'https://www.example.com/return.html',
            'WMI_FAIL_URL'          => 'https://www.example.com/cancel.html',
            'WMI_EXPIRED_DATE'      => '2020-01-21T12:43:08',
            'WMI_CREATE_DATE'       => '2020-01-01T12:43:08',
            'WMI_UPDATE_DATE'       => '2020-01-01T12:43:28',
            'WMI_ORDER_STATE'       => 'ACCEPTED',
            'WMI_SIGNATURE'         => 'X4lGf1Md2ldTTD6wz5zElg==',
        ), $data);

        $this->request->setSecretKey('1234');
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException', 'Wrong digital signature.');
        $this->request->getData();
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\WalletOne\Message\CompletePurchaseResponse', $response);
    }
}