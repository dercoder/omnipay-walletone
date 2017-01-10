<?php

namespace Omnipay\WalletOne\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    public function testSuccess()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
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

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('ACCEPTED', $response->getCode());
        $this->assertSame('TX123412', $response->getTransactionId());
        $this->assertSame('TX542312', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testFailure()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
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
            'WMI_ORDER_STATE'       => 'RETRY',
            'WMI_SIGNATURE'         => 'X4lGf1Md2ldTTD6wz5zElg==',
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('RETRY', $response->getCode());
        $this->assertSame('TX123412', $response->getTransactionId());
        $this->assertSame('TX542312', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testConfirm()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = $this->getMockBuilder('\Omnipay\WalletOne\Message\CompletePurchaseResponse')
            ->setConstructorArgs(array($request, array()))
            ->setMethods(array('exitWith'))
            ->getMock();
        $response->expects($this->once())
            ->method('exitWith');

        $response->confirm();
    }

    public function testError()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = $this->getMockBuilder('\Omnipay\WalletOne\Message\CompletePurchaseResponse')
            ->setConstructorArgs(array($request, array()))
            ->setMethods(array('exitWith'))
            ->getMock();
        $response->expects($this->once())
            ->method('exitWith');

        $response->error();
    }

    public function testOutput()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array());
        $this->expectOutputString('WMI_RESULT=RETRY&WMI_DESCRIPTION=Test+Message');
        $response->output('Retry', 'Test Message');
    }
}