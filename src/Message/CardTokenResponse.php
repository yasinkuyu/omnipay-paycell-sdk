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
  
        $responseHashData = $this->data->hashService->responseHash($this->getTransactionId(), $this->getResponseDateTime(), $this->getResponseCode(), $this->getCardToken());

        return $responseHashData === $this->getHashData();
    }

    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data->header->responseDescription ?? null;
    }

    /**
     * Get the card token.
     *
     * @return string|null
     */
    public function getCardToken()
    {
        return $this->data->cardToken ?? null;
    }

    /**
     * Get the hash Data.
     *
     * @return string|null
     */
    public function getHashData()
    {
        return $this->data->hashData ?? null;
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->data->header->transactionId ?? null;
    }
    
    /**
     * Get the response code.
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->data->header->responseCode ?? null;
    }
    
    /**
     * Get the response date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getResponseDateTime() {
        return $this->data->header->responseDateTime ?? null;
    }

}
