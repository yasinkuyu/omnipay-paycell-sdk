<?php

namespace Omnipay\PaycellSDK\Message;
 
use Omnipay\PaycellSDK\CommonParameters;
 
class SummaryRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->summary($data);

        return $this->createResponse($httpResponse);
    }

    protected function createResponse($data)
    {
        return $this->response = new QueryResponse($this, $data);
    }
}
