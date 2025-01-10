<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell Query Statu
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
        return $this->response = new TransactionResponse($this, $data);
    }
}
