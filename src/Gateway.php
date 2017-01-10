<?php

namespace Omnipay\WalletOne;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\WalletOne\Message\PurchaseRequest;
use Omnipay\WalletOne\Message\CompletePurchaseRequest;

/**
 * Class Gateway
 * @package Omnipay\WalletOne
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'WalletOne';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'secretKey'  => '',
            'algorithm'  => 'md5',
            'testMode'   => false
        );
    }

    /**
     * Get Wallet One merchant ID.
     *
     * @return string merchantId
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set Wallet One merchant ID.
     *
     * @param string $value merchantId
     *
     * @return $this
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get Wallet One secret key.
     *
     * @return string secretKey
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set Wallet One secret key.
     *
     * @param string $value secretKey
     *
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get Wallet One signature algorithm.
     *
     * @return string algorithm
     */
    public function getAlgorithm()
    {
        return $this->getParameter('algorithm');
    }

    /**
     * Set Wallet One signature algorithm.
     *
     * @param string $value algorithm
     *
     * @return $this
     */
    public function setAlgorithm($value)
    {
        return $this->setParameter('algorithm', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WalletOne\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WalletOne\Message\CompletePurchaseRequest', $parameters);
    }
}
