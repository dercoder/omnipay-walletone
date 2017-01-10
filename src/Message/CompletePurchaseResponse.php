<?php

namespace Omnipay\WalletOne\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CompletePurchaseResponse
 * @package Omnipay\WalletOne\Message
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function isSuccessful()
    {
        return $this->getCode() == 'ACCEPTED';
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['WMI_PAYMENT_NO'];
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['WMI_ORDER_ID'];
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->data['WMI_ORDER_STATE'];
    }

    /**
     * @param string $description
     */
    public function confirm($description = null)
    {
        $this->exitWith('OK', $description);
    }

    /**
     * @param string $description
     */
    public function error($description = null)
    {
        $this->exitWith('RETRY', $description);
    }

    /**
     * @param string $result
     * @param string $description
     *
     * @return string
     */
    public function output($result, $description)
    {
        echo 'WMI_RESULT=' . strtoupper($result) . '&WMI_DESCRIPTION=' . urlencode($description);
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $result
     * @param string $description
     */
    public function exitWith($result, $description)
    {
        header('Content-Type: text/plain; charset=utf-8');
        $this->output($result, $description);
        exit;
    }
}
