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
class Purchase3DResponse extends TransactionResponse
{
    /**
     * Get the isRedirect.
     *
     * @return bool
     */
    public function isRedirect()
    {
        // Check if the 'payForm' element exists in the HTML response
        return strpos($this->getRedirectData(), 'name="payForm"') !== false;
    }

    /**
     * Get the body.
     *
     * @return string|null
     */
    public function getRedirectData()
    {
        return isset($this->data->redirectContentResponse) ? trim($this->data->redirectContentResponse) : null;
    }
    
    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data->responseHeader->responseDescription ?? null;
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
        return $this->data->threeDSessionId ?? null;
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
        return $this->data->responseHeader->transactionId ?? null;
    }
    
    /**
     * Get the response code.
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->data->responseHeader->responseCode ?? null;
    }
    
    /**
     * Get the response date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getResponseDateTime() {
        return $this->data->responseHeader->responseDateTime ?? null;
    }

}
