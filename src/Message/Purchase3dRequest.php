<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;
use Omnipay\Paycell\Helpers\HashService;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Purchase3dRequest extends AbstractRequest
{

    use CommonParameters;

    protected $actionType = 'SALE';

    public function getData()
    {
        $hashService = new HashService();

        $transactionDateTime =  $this->getTransactionDateTime();
        $transactionId = $this->getTransactionId();

        $requestHashData = $hashService->requestHash($transactionId, $transactionDateTime);
        
        $cardTokenResponse = new CardTokenResponse($this, $this->getCardTokenSecure($requestHashData));
 
        if(!$cardTokenResponse->isSuccessful()) {
            die("Invalid card token. " . $cardTokenResponse->getMessage());
        }
 
        return [
           "hashData" => $requestHashData,
           "cardToken" => $cardTokenResponse->getCardToken()
        ];
    }

    public function sendData($data)
    {

        // Initiate a 3D Secure session and get the HTTP response.
        $httpResponse = $this->getThreeDSession($data);
         
        // Extract the 3D Secure session ID from the response.
        // Prepare an array with the 3D Secure session ID and callback URL.
        $httpResponse->redirectContentResponse = $this->threeDSecure([
            "threeDSessionId" => $httpResponse->threeDSessionId,
        ]);

        // Create and return a response
        return $this->createResponse($httpResponse);
    } 

    /**
     * Create a response object.
     *
     * @param array $data The response data
     * @return Purchase3DResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new Purchase3DResponse($this, $data);
    }
}
