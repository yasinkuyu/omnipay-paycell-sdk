<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class TransactionResponse extends AbstractResponse
{
 
    /**
     * Check if the transaction was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->responseHeader->responseDescription) ? ($this->data->responseHeader->responseDescription === "Success") : false;
    }
  
    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->data->responseHeader->responseDescription) ? $this->data->responseHeader->responseDescription : null;
    }

    public function getData()
    {
        return parent::getData();
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->data->responseHeader->transactionId) ? $this->data->responseHeader->transactionId : null;
    }

    // Omnipay transaction
    public function getTransactionReference()
    {
        return $this->getTransactionId();
    }
    
    /**
     * Get the transaction date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getTransactionDateTime() {
        return isset($this->data->responseHeader->transactionDateTime) ? $this->data->responseHeader->transactionDateTime : null;
    }

    /**
     * Get the order ID.
     *
     * @return string|null
     */
    public function getOrderId()
    {
        return isset($this->data->orderId) ? $this->data->orderId : null;
    }

    /**
     * Get the acquirer bank code.
     *
     * @return string|null
     */
    public function getAcquirerBankCode()
    {
        return isset($this->data->acquirerBankCode) ? $this->data->acquirerBankCode : null;
    }

    /**
     * Get the issuer bank code.
     *
     * @return string|null
     */
    public function getIssuerBankCode()
    {
        return isset($this->data->issuerBankCode) ? $this->data->issuerBankCode : null;
    }

    /**
     * Get the approval code.
     *
     * @return string|null
     */
    public function getApprovalCode()
    {
        return isset($this->data->approvalCode) ? $this->data->approvalCode : null;
    }

    /**
     * Get the reconciliation date.
     *
     * @return string|null
     */
    public function getReconciliationDate()
    {
        return isset($this->data->reconciliationDate) ? $this->data->reconciliationDate : null;
    }

    /**
     * Get the Iyzico payment ID.
     *
     * @return string|null
     */
    public function getIyzPaymentId()
    {
        return isset($this->data->iyzPaymentId) ? $this->data->iyzPaymentId : null;
    }
    
    /**
     * Get the Three D Session Id.
     * 
     * 3D doğrulama işlemine ait session ID değeridir.
     * 
     * @return string|null
     */
    public function getThreeDSessionId()
    {
        return isset($this->data->threeDSessionId) ? $this->data->threeDSessionId : null;
    }

    /**
     * Get the Iyzico payment transaction ID.
     *
     * @return string|null
     */
    public function getIyzPaymentTransactionId()
    {
        return isset($this->data->iyzPaymentTransactionId) ? $this->data->iyzPaymentTransactionId : null;
    }

    /**
     * Get the Retry Status Code.
     *
     * @return int|null The retry status code if set, otherwise null.
     */
    public function getRetryStatusCode()
    {
        return isset($this->data->retryStatusCode) ? $this->data->retryStatusCode : null;
    }


    /**
     * Get the Retry Status Description.
     *
     * @return string|null The retry status description if set, otherwise null.
     */
    public function getRetryStatusDescription()
    {
        return isset($this->data->retryStatusDescription) ? $this->data->retryStatusDescription : null;
    }

    /**
     * Get extra parameters
     *
     * @return string|null
     */
    public function getExtraParameters() {
        return isset($this->data->extraParameters) ? $this->data->extraParameters : null;
    }

    /**
     * Get extra parameters
     *
     * @return string|null
     */
    public function getProvisionList() {
        return isset($this->data->provisionList) ? $this->data->provisionList : [];
    }
}
