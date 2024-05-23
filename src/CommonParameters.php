<?php

namespace Omnipay\Paycell;

trait CommonParameters
{
    
    public function getDefaultParameters()
    {

        $transactionDateTime = substr(date_format(new \DateTime(), "YmdHisu"), 0, 17);

        return [

            // default parameters
            'prefix' => 666,
            'applicationName' => 'PAYCELLTEST',
            'applicationPwd' => 'PaycellTestPassword',
            'secureCode' => 'PAYCELL12345',
            'eulaID' => '17',
            'merchantCode' => '9998',
            'referenceNumberPrefix' => '001',

            'transactionDateTime' => $transactionDateTime, // YYYYMMddHHmmssSSS
            'transactionId' => $transactionDateTime,
            
            'msisdn' => '',

            'paymentSecurity' => false,
            'referenceNumber' => $transactionDateTime

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
     * Get the prefix.
     *
     * @return mixed
     */
    public function getReferenceNumberPrefix()
    {
        return $this->getParameter('referenceNumberPrefix');
    }

    /**
     * Set the prefix.
     *
     * @param mixed $value The prefix value
     * @return $this
     */
    public function setReferenceNumberPrefix($value)
    {
        return $this->setParameter('referenceNumberPrefix', $value);
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
     * Set the msisdn.
     * 
     * Müşterinin uygulamaya login olduğu telefon numarası. 
     * Ülke kodu + Telefon No formatında iletilir.
     *
     * @param mixed $value The msisdn value
     * @return $this
     */
    public function setMsisdn($value)
    {
        return $this->setParameter('msisdn', $value);
    }

    /**
     * Get the msisdn.
     *
     * @return mixed
     */
    public function getMsisdn()
    {
        return $this->getParameter('msisdn');
    }

    /**
     * Set the referance number.
     *
     * @param mixed $value The referance number value
     * @return $this
     */
    public function setReferenceNumber($value)
    {
        return $this->setParameter('referenceNumber', $this->getParameter('referenceNumberPrefix') .  $value);
    }

    /**
     * Get the referance number.
     * 
     * Akaryakıt ödeme işlemlerinde kullanılır. Üye işyeri uygulaması üzerinden 
     * başlatılan normal ödeme işlemlerinde gönderilmez.
     *
     * @return mixed
     */
    public function getReferenceNumber()
    {
        return $this->getParameter('referenceNumber');
    }

    /**
     * Set the merchant code.
     * 
     * Ödeme işleminin başlatıldığı Paycell’de tanımlı üye işyeri kodu bilgisi gönderilir. 
     * Entegrasyon sonrasında her tanımlanan yeni üye işyeri için Paycell tarafından merchantCode değeri paylaşılır.
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
    public function getTransactionDateTime() {
        return $this->getParameter('transactionDateTime');
    }

    /**
     * Set the transaction date time.
     *
     * @param mixed $value The transaction date time value
     * @return $this
     */
    public function setTransactionDateTime($value)
    {
        return $this->setParameter('transactionDateTime', $value);
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null The transaction ID.
     */
    public function getTransactionId() {
        return $this->getParameter('transactionId');
    }

    /**
     * Set the transaction ID.
     *
     * @param string $value The transaction ID.
     * @return $this
     */
    public function setTransactionId($value) {
        return $this->setParameter('transactionId', $this->getParameter('prefix') . $value);
    }

    /**
     * Retrieves the client IP address.
     *
     * @return string|null The client IP address.
     */
    public function getClientIPAddress() {
        return $_SERVER['REMOTE_ADDR'] ?? "127.0.0.1";
    }
}