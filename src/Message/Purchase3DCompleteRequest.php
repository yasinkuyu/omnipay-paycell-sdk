<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Paycell\CommonParameters;
use Omnipay\Paycell\Helpers\HashService;
use Omnipay\Paycell\Gateway;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Purchase3DCompleteRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        
    }

    public function sendData($data)
    {
        $httpResponse = $this->getThreeDSessionResult();

        return $this->createResponse($httpResponse);
    } 

    protected function createResponse($data)
    {
        return $this->response = new Purchase3DCompleteResponse($this, $data);
    }
}
