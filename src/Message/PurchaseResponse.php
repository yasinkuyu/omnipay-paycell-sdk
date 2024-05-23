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
class PurchaseResponse extends AbstractResponse
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
     * Get the isRedirect.
     *
     * @return string|null
     */
    public function isRedirect()
    {
        return isset($this->data->responseHeader->isRedirect) ? $this->data->responseHeader->isRedirect : false;
    }


    /**
     * Get the redirect url.
     *
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return isset($this->data->responseHeader->redirectUrl) ? $this->data->responseHeader->redirectUrl : null;

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

    /**
     * Get the response stasus code 0: Success, >0: Fail.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data->responseHeader->responseCode) ? $this->data->responseHeader->responseCode : null;
    }

    /**
     * Get the body.
     *
     * @return string|null
     */
    public function getRedirectContent()
    {
        return isset($this->data) ? $this->data : null;
    }

    /**
     * Get return response hash data
     *
     * @return string
     */
    public function getHashData() {
        return isset($this->data->hashData) ? $this->data->hashData : null;
    }

    /**
     * Get the card token.
     *
     * @return string|null
     */
    public function getCardToken()
    {
        return isset($this->data->cardToken) ? $this->data->cardToken : null;
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
}
