<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class PurchaseRequest extends AbstractRequest
{

    use CommonParameters;

    protected $actionType = 'SALE';

    public function getData()
    {
        $cardTokenResponse = $this->getCardTokenSecure();

        $cardTokenResponse = $this->createResponse($cardTokenResponse);;

        if(!$cardTokenResponse->getCardToken()) {
            die("Invalid card token. " . $cardTokenResponse->getMessage());
        }

        return [
           'cardToken' => $cardTokenResponse->getCardToken()
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->provision($data);

        // Create and return a response
        return $this->createResponse($httpResponse);
    } 

    /**
     * Create a response object.
     *
     * @param array $data The response data
     * @return PurchaseResponse
     */
    protected function createResponse($data)
    {
        echo "provision createResponse";
        echo PHP_EOL;
print_r($data);
        return $this->response = new PurchaseResponse($this, $data);
    }
}
