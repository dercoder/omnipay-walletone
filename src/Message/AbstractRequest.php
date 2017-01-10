<?php

namespace Omnipay\WalletOne\Message;

/**
 * Class AbstractRequest
 * @package Omnipay\WalletOne\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
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
     * @param array $data
     *
     * @return string
     */
    public function getSignature(array $data)
    {
        foreach ($data as $name => $val) {
            if (is_array($val)) {
                usort($val, 'strcasecmp');
                $fields[$name] = $val;
            }
        }

        uksort($data, 'strcasecmp');
        $string = '';

        foreach ($data as $value) {
            if (is_array($value))
                foreach ($value as $v) {
                    $v = iconv('utf-8', 'windows-1251', $v);
                    $string .= $v;
                }
            else {
                $value = iconv('utf-8', 'windows-1251', $value);
                $string .= $value;
            }
        }

        return base64_encode(pack('H*', hash($this->getAlgorithm(), $string . $this->getSecretKey())));
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function hasValidSignature(array $data)
    {
        $remoteSignature = $data['WMI_SIGNATURE'];
        unset($data['WMI_SIGNATURE']);
        ksort($data, SORT_STRING);
        $string = '';

        foreach ($data as $name => $value) {
            $value = iconv('utf-8', 'windows-1251', $value);
            $string .= $value;
        }

        $localSignature = base64_encode(pack('H*', hash($this->getAlgorithm(), $string . $this->getSecretKey())));
        return $remoteSignature == $localSignature;
    }
}
