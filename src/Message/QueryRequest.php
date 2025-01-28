<?php

namespace Omnipay\PaycellSDK\Message;
 
use Omnipay\PaycellSDK\CommonParameters;

/**
 * Paycell SDK Query Status
 * 

 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */

class QueryRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->query($data);
        return $this->createResponse($httpResponse);
    } 

    protected function createResponse($data)
    {
        return $this->response = new QueryResponse($this, $data);
    }
}
