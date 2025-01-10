<?php

namespace Omnipay\Paycell;

trait CommonParameters
{
    
    public function getDefaultParameters()
    {

        $transactionDateTime = substr(date("YmdHisu"), 0, 17);

        return [

            // default parameters
            'prefix' => '',
            'applicationName' => '',
            'applicationPwd' => '',
            'eulaID' => '',
            'merchantCode' => '',
            'msisdn' => '',
            'installment' => " ",

            'secureCode' => '',
            'terminalCode' => '',
            'paymentReferenceNumber' => '',
            'amount' => '',
            'paymentSecurity' => 'NON_THREED_SECURE',
            'hostAccount' => 'xxxxxx@xxxx.com',
            'currency' => '99',
            'installmentPlan' => array(),
            'language' => 'tr',

            'postResultUrl' => '',
            'returnUrl' => '',

            'transactionDateTime' => $transactionDateTime, // YYYYMMddHHmmssSSS
            'transactionId' => $transactionDateTime,

            'paymentSecurity' => false,
            'referenceNumber' => " ",
            'originalReferenceNumber' => null,
            'originalPaymentReferenceNumber' => null,

            // Three D Secure
            '3D' => false

        ];
    }


    /**
     * Get the msisdn.
     *
     * @return mixed
     */
    public function getMsisdn() {
        return $this->getParameter('msisdn');
    }

    /**
     * Set the msisdn.
     *
     * @param mixed $value The msisdn value
     * @return $this
     */
    public function setMsisdn($value) {
        return $this->setParameter('msisdn', $value);
    }   

    /**
    * Set the trackingId.
    *
    * @param mixed $value The trackingId value
    * @return $this
    */
    public function setTrackingId($value)
    {
        return $this->setParameter('trackingId', $value);
    }

    /**
    * Get the trackingId.
    *
    * @return mixed
    */
    public function getTrackingId()
    {
        return $this->getParameter('trackingId');
    }

    /**
    * Set the trackingUrl.
    *
    * @param mixed $value The trackingUrl value
    * @return $this
    */
    public function setTrackingUrl($value)
    {
        return $this->setParameter('trackingUrl', $value);
    }

    /**
    * Get the trackingUrl.
    *
    * @return mixed
    */
    public function getTrackingUrl()
    {
        return $this->getParameter('trackingUrl');
    }



    
    /**
     * Set the secureCode.
    *
    * @param mixed $value The secureCode value
    * @return $this
    */
    public function setSecureCode($value)
    {
        return $this->setParameter('secureCode', $value);
    }

    /**
    * Get the secureCode.
    *
    * @return mixed
    */
    public function getSecureCode()
    {
        return $this->getParameter('secureCode');
    }

    /**
    * Set the terminalCode.
    *
    * @param mixed $value The terminalCode value
    * @return $this
    */
    public function setTerminalCode($value)
    {
        return $this->setParameter('terminalCode', $value);
    }

    /**
    * Get the terminalCode.
    *
    * @return mixed
    */
    public function getTerminalCode()
    {
        return $this->getParameter('terminalCode');
    }

    /**
    * Set the paymentReferenceNumber.
    *
    * @param mixed $value The paymentReferenceNumber value
    * @return $this
    */
    public function setPaymentReferenceNumber($value)
    {
        return $this->setParameter('paymentReferenceNumber', $value);
    }

    /**
    * Get the paymentReferenceNumber.
    *
    * @return mixed
    */
    public function getPaymentReferenceNumber()
    {
        return $this->getParameter('paymentReferenceNumber');
    }
    

    /**
    * Set the amount.
    *
    * @param mixed $value The amount value
    * @return $this
    */
    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    /**
    * Get the amount.
    *
    * @return mixed
    */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
    * Set the paymentSecurity.
    *
    * @param mixed $value The paymentSecurity value
    * @return $this
    */
    public function setPaymentSecurity($value)
    {
        return $this->setParameter('paymentSecurity', $value);
    }

    /**
    * Get the paymentSecurity.
    *
    * @return mixed
    */
    public function getPaymentSecurity()
    {
        return $this->getParameter('paymentSecurity');
    }

    /**
    * Set the hostAccount.
    *
    * @param mixed $value The hostAccount value
    * @return $this
    */
    public function setHostAccount($value)
    {
        return $this->setParameter('hostAccount', $value);
    }

    /**
    * Get the hostAccount.
    *
    * @return mixed
    */
    public function getHostAccount()
    {
        return $this->getParameter('hostAccount');
    }

    /**
    * Set the currency.
    *
    * @param mixed $value The currency value
    * @return $this
    */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    /**
    * Get the currency.
    *
    * @return mixed
    */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
    * Set the installmentPlan.
    *
    * @param mixed $value The installmentPlan value
    * @return $this
    */
    public function setInstallmentPlan($value)
    {
        return $this->setParameter('installmentPlan', $value);
    }

    /**
    * Get the installmentPlan.
    *
    * @return mixed
    */
    public function getInstallmentPlan()
    {
        return $this->getParameter('installmentPlan');
    }

    /**
    * Set the language.
    *
    * @param mixed $value The language value
    * @return $this
    */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
    * Get the language.
    *
    * @return mixed
    */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }


    /**
     * Get the postResultUrl.
     *
     * @return mixed
     */
    public function getPostResultUrl()
    {
        return $this->getParameter('postResultUrl');
    }

    /**
     * Set the postResultUrl.
     *
     * @param mixed $value The postResultUrl value
     * @return $this
     */
    public function setPostResultUrl($value)
    {
        return $this->setParameter('postResultUrl', $value);
    }

    /**
     * Get the returnUrl.
     *
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    /**
     * Set the returnUrl.
     *
     * @param mixed $value The returnUrl value
     * @return $this
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }




    /**
     * Get the 3D value.
     *
     * @return mixed The 3D value.
     */
    public function get3D()
    {
        return $this->getParameter('3D');
    }

    /**
     * Set the 3D value.
     *
     * This method sets the 3D value for the user, which indicates whether the transaction is 3D secure or not.
     *
     * @param mixed $value The 3D value to set.
     * @return $this
     */
    public function set3D($value)
    {
        return $this->setParameter('3D', $value);
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
     *  Müşterinin uygulamaya login olduğu telefon numarası. Ülke kodu + Telefon No formatında iletilir.
     * 
     * @param mixed $value The prefix value
     * @return $this
     */
    public function setPrefix($value)
    {
        return $this->setParameter('prefix', $value);
    }

    /**
     * Get the installment.
     *
     * @return mixed
     */
    public function getInstallment() {
        return $this->getParameter('installment');
    }

    /**
     * Set the installment.
     *
     * @param mixed $value The installment value
     * @return $this
     */
    public function setInstallment($value) {
        return $this->setParameter('installment', $value);
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
     * Set the referance number.
     * 
     * Üye işyeri uygulaması tarafından üretilecek unique numerik işlem referans numarası değeridir. 
     * İlk 3 hanesi uygulama bazında unique’dir, bu değer entegrasyon aşamasında Paycell tarafından bildirilecektir.
     *
     * @param mixed $value The referance number value
     * @return $this
     */
    public function setReferenceNumber($value)
    {
        return $this->setParameter('referenceNumber',  $value);
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
     * Set the original referance number.
     * 
     * İade edilecek işlemin “referenceNumber” değeridir.
     * 
     * @param mixed $value The origianl referance number value
     * @return $this
     */
    public function setOriginalReferenceNumber($value)
    {
        return $this->setParameter('originalReferenceNumber', $value);
    }

    /**
     * Get the origianl referance number.
     * 
     * @return mixed
     */
    public function getOriginalReferenceNumber()
    {
        return $this->getParameter('originalReferenceNumber');
    }

    /** 
     * Set the originalPaymentReferenceNumber.
     * 
     * @param mixed $value The originalPaymentReferenceNumber value
     * @return $this
     */
    public function setOriginalPaymentReferenceNumber($value)
    {
        return $this->setParameter('originalPaymentReferenceNumber', $value);
    }

    /**
     * Get the originalPaymentReferenceNumber.
     * 
     * @return mixed
     */
    public function getOriginalPaymentReferenceNumber()
    {
        return $this->getParameter('originalPaymentReferenceNumber');
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
        return $this->getParameter('transactionId') ? $this->getPrefix() . $this->getParameter('transactionId') : " ";
    }

    /**
     * Set the transaction ID.
     *
     * @param string $value The transaction ID.
     * @return $this
     */
    public function setTransactionId($value) {
        return $this->setParameter('transactionId', $value);
    }

    /**
     * Retrieves the client IP address.
     *
     * @return string|null The client IP address.
     */
    public function getClientIPAddress() {
        return $_SERVER['REMOTE_ADDR'] ?? "127.0.0.1";
    }
 

    /**
     * Set the pointAmount.
     * 
     * Amount of points to be used in the transaction.
     *
     * @param mixed $value The pointAmount value
     * @return $this
     */
    public function setPointAmount($value)
    {
        return $this->setParameter('pointAmount', $value);
    }

    /**
     * Get the pointAmount.
     *
     * @return mixed
     */
    public function getPointAmount()
    {
        return $this->getParameter('pointAmount');
    }


    /**
     * Set the threeDSessionId.
     * 
     * Session ID for the 3D Secure transaction.
     *
     * @param mixed $value The threeDSessionId value
     * @return $this
     */
    public function setThreeDSessionId($value)
    {
        return $this->setParameter('threeDSessionId', $value);
    }

    /**
     * Get the threeDSessionId.
     *
     * @return mixed
     */
    public function getThreeDSessionId()
    {
        return $this->getParameter('threeDSessionId');
    }

    /**
     * Set the acquirerBankCode.
     * 
     * Code representing the bank that is acquiring the transaction.
     *
     * @param mixed $value The acquirerBankCode value
     * @return $this
     */
    public function setAcquirerBankCode($value)
    {
        return $this->setParameter('acquirerBankCode', $value);
    }

    /**
     * Get the acquirerBankCode.
     *
     * @return mixed
     */
    public function getAcquirerBankCode()
    {
        return $this->getParameter('acquirerBankCode');
    }

}