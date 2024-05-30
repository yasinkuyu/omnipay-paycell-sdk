<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Paycell\Helpers\HashService;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class CardTokenResponse extends AbstractResponse
{

    /**
     * Check if the transaction was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $hashService = new HashService();
 
        $responseHashData = $hashService->responseHash($this->getTransactionId(), $this->getResponseDateTime(), $this->getResponseCode(), $this->getCardToken());

        return $responseHashData === $this->getHashData();
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
     * Get the card token.
     *
     * @return string|null
     */
    public function getCardToken()
    {
        return isset($this->data->cardToken) ? $this->data->cardToken : null;
    }

    /**
     * Get the hash Data.
     *
     * @return string|null
     */
    public function getHashData()
    {
        return isset($this->data->hashData) ? $this->data->hashData : null;
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
    
    /**
     * Get the response code.
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return isset($this->data->header->responseCode) ? $this->data->header->responseCode : null;
    }
    
    /**
     * Get the response date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getResponseDateTime() {
        return isset($this->data->header->responseDateTime) ? $this->data->header->responseDateTime : null;
    }

}
