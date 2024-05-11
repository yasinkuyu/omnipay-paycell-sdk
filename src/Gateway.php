<?php

namespace Omnipay\Paycell;

use Omnipay\Common\AbstractGateway;

/**
 * Paycell Gateway
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Gateway extends AbstractGateway
{
  
    public function getName()
    {
        return 'Paycell';
    }

    public function getDefaultParameters()
    {

        $transactionDateTime = substr(date_format(new \DateTime(), "YmdHisu"), 0, 17);

        return [
            'prefix' => '666',
            'applicationName' => 'PAYCELLTEST',
            'applicationPwd' => 'PaycellTestPassword',
            'secureCode' => 'PAYCELL12345',
            'eulaID' => '17',
            'merchantCode' => '9998',

            'transactionDateTime' => $transactionDateTime,
            'transactionId' => 666 . $transactionDateTime, 
        ];
    }

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->getParameter('prefix');
    }

    /**
     * Set the prefix.
     *
     * @param mixed $value The prefix value
     * @return $this
     */
    public function setPrefix($value)
    {
        return $this->setParameter('prefix', $value);
    }

    /**
     * Get the application name.
     *
     * @return mixed
     */
    public function getApplicationName()
    {
        return $this->getParameter('applicationName');
    }

    /**
     * Set the application name.
     *
     * @param mixed $value The application name value
     * @return $this
     */
    public function setApplicationName($value)
    {
        return $this->setParameter('applicationName', $value);
    }

    /**
     * Get the application password.
     *
     * @return mixed
     */
    public function getApplicationPwd()
    {
        return $this->getParameter('applicationPwd');
    }

    /**
     * Set the application password.
     *
     * @param mixed $value The application password value
     * @return $this
     */
    public function setApplicationPwd($value)
    {
        return $this->setParameter('applicationPwd', $value);
    }

    /**
     * Get the secure code.
     *
     * @return mixed
     */
    public function getSecureCode()
    {
        return $this->getParameter('secureCode');
    }

    /**
     * Get the End User License Agreement (EULA) ID.
     *
     * @return mixed
     */
    public function getEulaID()
    {
        return $this->getParameter('eulaID');
    }

    /**
     * Set the End User License Agreement (EULA) ID.
     *
     * @param mixed $value The EULA ID value
     * @return $this
     */
    public function setEulaID($value)
    {
        return $this->setParameter('eulaID', $value);
    }

    /**
     * Get the merchant code.
     *
     * @return mixed
     */
    public function getMerchantCode()
    {
        return $this->getParameter('merchantCode');
    }

    /**
     * Set the merchant code.
     *
     * @param mixed $value The merchant code value
     * @return $this
     */
    public function setMerchantCode($value)
    {
        return $this->setParameter('merchantCode', $value);
    }

    /**
     * Get the transaction date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getTransactionDateTime(): ?string {
        return $this->getParameter('transactionDateTime');
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null The transaction ID.
     */
    public function getTransactionId(): ?string {
        return $this->getParameter('prefix') . $this->getParameter('transactionId');
    }

    /**
     * Set the transaction ID.
     *
     * @param string $value The transaction ID.
     * @return $this
     */
    public function setTransactionId(string $value) {
        return $this->setParameter('transactionId', $this->getParameter('prefix') . $value);
    }

    /**
     * Retrieves the client IP address.
     *
     * @return string|null The client IP address.
     */
    public function getClientIpAddress(): ?string {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    /**
     * Set the secure code for the transaction.
     *
     * @param mixed $value The secure code value
     * @return $this
     */
    public function setSecureCode($value)
    {
        return $this->setParameter('secureCode', $value);
    }

    /**
     * Initiate a purchase request.
     *
     * @param array $parameters Additional parameters for the purchase
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Paycell\Message\PurchaseRequest', $parameters);
    }

}