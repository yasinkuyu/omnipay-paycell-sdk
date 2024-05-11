<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
abstract class AbstractTransaction extends AbstractRequest {
     
    /**
     * Get data to be sent in the request.
     *
     * @return array
     */
    public function getData()
    {
        // Ensure card is present and valid
        $this->validate('amount','card');
        $this->getCard()->validate();
        $currency = $this->getCurrency();

        // Get card information
        $card = $this->getCard();

        // Determine mode based on test mode
        $mode = $this->getTestMode() ? "test" : "prod";
        
        // Prepare data for request
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'prefix' => $this->getParameter('prefix'),
            'applicationName' => $this->getParameter('applicationName'),
            'applicationPwd' => $this->getParameter('applicationPwd'),
            'secureCode' => $this->getParameter('secureCode'),
            'eulaID' => $this->getParameter('eulaID'),
            'merchantCode' => $this->getParameter('merchantCode'),
            // Add other parameters here...
        ];
    }

    /**
     * Send data to the payment gateway.
     *
     * @param array $data The data to send
     * @return mixed
     */
    public function sendData($data)
    {
        $this->validate( 'card');

        $card = $this->getCard();
        $mode = $this->getTestMode() ? "test" : "prod";
 
        // Create a new PaymentService instance
        $service = new PaymentService($mode);
        $purchase = $service->getCardTokenSecure();

        $requestData = $purchase['data'];

        $requestData["creditCardNo"] = $card->getNumber();
        $requestData["expireDateMonth"] = $card->getExpiryDate('m');
        $requestData["expireDateYear"] = $card->getExpiryDate('Y');
        $requestData["cvcNo"] = $card->getCvv();
        
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $purchase["url"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
              "Content-Type: application/json",
            ],
        ]);
        
        $httpResponse = curl_exec($curl);
        
        curl_close($curl);
        
        $httpResponse = json_decode($httpResponse);

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

        print_r($data);
        return $this->response = new PurchaseResponse($this, $data);
    }

    // abstract public function getEndpoint();

    // abstract protected function createResponse($data);
}
