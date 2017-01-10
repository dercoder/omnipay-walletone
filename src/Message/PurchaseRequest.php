<?php

namespace Omnipay\WalletOne\Message;

use DateTime;
use DateTimeZone;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class PurchaseRequest
 * @package Omnipay\WalletOne\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * The expiry date of payment. Date is indicated in Western European time zone (UTC+0) and should be more than
     * current date value(ISO 8601), for example: 2013-11-09T16:18:52.
     * Please note: invoice validity period may not exceed 30 days after the moment of issue!
     *
     * @return string
     * @throws InvalidRequestException
     */
    public function getExpirationDate()
    {
        $expirationDate = $this->getParameter('expirationDate');
        if (!is_object($expirationDate) || !$expirationDate instanceof DateTime) {
            throw new InvalidRequestException('Please specify expiration date as a DateTime object');
        }

        return $expirationDate
            ->setTimezone(new DateTimeZone('UTC'))
            ->format('Y-m-d\TH:i:s');
    }

    /**
     * The expiry date of payment. Date is indicated in Western European time zone (UTC+0) and should be more than
     * current date value(ISO 8601), for example: 2013-11-09T16:18:52.
     * Please note: invoice validity period may not exceed 30 days after the moment of issue!
     *
     * @param \DateTime $value
     *
     * @return $this
     */
    public function setExpirationDate($value)
    {
        return $this->setParameter('expirationDate', $value);
    }

    /**
     * These parameters allow you to control available payment methods. Read more in the section
     * https://www.walletone.com/en/merchant/documentation/#step4
     *
     * @return array|null
     */
    public function getEnabledPayments()
    {
        return $this->getParameter('enabledPayments');
    }

    /**
     * These parameters allow you to control available payment methods. Read more in the section
     * https://www.walletone.com/en/merchant/documentation/#step4
     *
     * @param array $value
     *
     * @return $this
     */
    public function setEnabledPayments(array $value)
    {
        return $this->setParameter('enabledPayments', $value);
    }

    /**
     * These parameters allow you to control available payment methods. Read more in the section
     * https://www.walletone.com/en/merchant/documentation/#step4
     *
     * @return array|null
     */
    public function getDisabledPayments()
    {
        return $this->getParameter('disabledPayments');
    }

    /**
     * These parameters allow you to control available payment methods. Read more in the section
     * https://www.walletone.com/en/merchant/documentation/#step4
     *
     * @param array $value
     *
     * @return $this
     */
    public function setDisabledPayments(array $value)
    {
        return $this->setParameter('disabledPayments', $value);
    }

    /**
     * Allows to show the methods of payment available for user according to his location.
     * 0 — shows the methods regardless of the user's country;
     * 1 — the user's country and the display of methods determines according to the IP.
     *
     * @return string
     */
    public function getAutoLocation()
    {
        return $this->getParameter('autoLocation') ? '1' : '0';
    }

    /**
     * Allows to show the methods of payment available for user according to his location.
     * 0 — shows the methods regardless of the user's country;
     * 1 — the user's country and the display of methods determines according to the IP.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setAutoLocation($value)
    {
        return $this->setParameter('autoLocation', (bool) $value);
    }

    /**
     * To avoid problems when using national characters parameter WMI_DESCRIPTION, it is possible to encode this
     * parameter in BASE64-string (UTF-8).
     * Transmission format: BASE64:
     * Sample: BASE64:RGVtbyBvcmRlciBwYXltZW50
     *
     * @return string
     */
    public function getEncodedDescription()
    {
        return 'BASE64:' . base64_encode($this->getDescription());
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate(
            'merchantId',
            'secretKey',
            'amount',
            'currency',
            'transactionId',
            'description',
            'returnUrl',
            'cancelUrl',
            'expirationDate'
        );

        $data = array(
            'WMI_MERCHANT_ID'    => $this->getMerchantId(),
            'WMI_PAYMENT_AMOUNT' => $this->getAmount(),
            'WMI_CURRENCY_ID'    => $this->getCurrencyNumeric(),
            'WMI_PAYMENT_NO'     => $this->getTransactionId(),
            'WMI_DESCRIPTION'    => $this->getEncodedDescription(),
            'WMI_SUCCESS_URL'    => $this->getReturnUrl(),
            'WMI_FAIL_URL'       => $this->getCancelUrl(),
            'WMI_EXPIRED_DATE'   => $this->getExpirationDate(),
            'WMI_AUTO_LOCATION'  => $this->getAutoLocation()
        );

        if ($enabledPayments = $this->getEnabledPayments()) {
            $data['WMI_PTENABLED'] = $enabledPayments;
        }

        if ($disabledPayments = $this->getDisabledPayments()) {
            $data['WMI_PTDISABLED'] = $disabledPayments;
        }

        $data['WMI_SIGNATURE'] = $this->getSignature($data);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }
}
