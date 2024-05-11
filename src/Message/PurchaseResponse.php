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
        return isset($this->data->header->transactionId);
    }

    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->data->header->responseDescription) ? $this->data->header->responseDescription : null;
    }

    /**
     * Get the response stasus code 0: Success, >0: Fail.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data->header->responseCode) ? $this->data->header->responseCode : null;
    }

    /**
     * Get return hash data
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
        return isset($this->data->header->transactionId) ? $this->data->header->transactionId : null;
    }
    
}
