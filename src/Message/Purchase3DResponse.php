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
}
