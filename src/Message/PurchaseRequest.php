<?php

namespace Omnipay\PaycellSDK\Message;
 
use Omnipay\PaycellSDK\CommonParameters;

/**
 * Paycell SDK Purchase Request
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */

class PurchaseRequest extends AbstractRequest
{
    use CommonParameters;

    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->provision($data);
        return $this->createResponse($httpResponse);
    }

    protected function createResponse($data)
    {
        return $this->response = new TransactionResponse($this, $data);
    }
}
