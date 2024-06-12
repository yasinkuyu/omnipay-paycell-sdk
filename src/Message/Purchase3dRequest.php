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
class Purchase3DRequest extends AbstractRequest
{

    use CommonParameters;

    protected $actionType = 'SALE';

    public function getData()
    {
        $hashService = new HashService();
        $hashService->applicationName = $this->getApplicationName();
        $hashService->applicationPwd = $this->getApplicationPwd();
        $hashService->secureCode = $this->getSecureCode();

        $transactionId = $this->getTransactionId();
        $transactionDateTime = $this->getTransactionDateTime();

        $requestHashData = $hashService->requestHash($transactionId, $transactionDateTime);
        
        $cardTokenResponse = $this->getCardTokenSecure($requestHashData, $transactionId, $transactionDateTime);
        $cardTokenResponse->hashService = $hashService;

        $cardTokenResponse = new CardTokenResponse($this, $cardTokenResponse);
  
        if (!$cardTokenResponse->isSuccessful()) {
            throw new \Exception("Invalid card token. " . $cardTokenResponse->getMessage());
        }
  
        return [
           "hashData" => $cardTokenResponse->getHashData(),
           "cardToken" => $cardTokenResponse->getCardToken()
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->getThreeDSession($data);

        $httpResponse->cardToken = $data['cardToken'];
        $httpResponse->hashData = $data['hashData'];

        $httpResponse->redirectContentResponse = $this->threeDSecure([
            "threeDSessionId" => $httpResponse->threeDSessionId,
        ]);

        return $this->createResponse($httpResponse);
    } 

    protected function createResponse($data)
    {
        return $this->response = new Purchase3DResponse($this, $data);
    }
}
