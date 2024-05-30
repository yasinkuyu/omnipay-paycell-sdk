<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;
use Omnipay\Paycell\Helpers\HashService;

/**
 * Paycell Provision
 * 
 * Paycell’de tanımlı bir kart ile veya müşterinin kart numarası girerek 
 * gerçekleştireceği ödeme isteklerinin Paycell’e iletilmesi amacıyla kullanılır. 
 * Ödeme alternatifleri ve serviste iletilecek cardId ve cardToken kullanımları aşağıdaki şekildeki gibidir.
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */

/* 
    Example 
    Request:
    {
        "requestHeader": {
            "applicationName": "XXXX",
            "applicationPwd": "XXXX",
            "clientIPAddress": "10.252.187.81",
            "transactionDateTime": "20160309084056197",
            "transactionId": "12345678901234567893"
        },
        "cardId": "bd142ddd-9fa4-46a6-8024-895500274826",
        "merchantCode": "2003",
        "msisdn": "5380521479",
        "referenceNumber": "12333374401234567892",
        "amount": "2351",
        "paymentType": "SALE",
        "acquirerBankCode": "111",
        "threeDSessionId": " "
    }        
    Response:
    {
        "responseHeader": {
            "transactionId": "12345678901234567893",
            "responseDateTime": "20181017104734492",
            "responseCode": "0",
            "responseDescription": "Success"
        },
        "extraParameters": null,
        "orderId": "551952788718101710473129",
        "acquirerBankCode": "111",
        "issuerBankCode": "111",
        "approvalCode": "646174",
        "reconciliationDate": "20181017"
    }   
 */
class PurchaseRequest extends AbstractRequest
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

        $httpResponse = $this->provision($data);

        // Create and return a response
        return $this->createResponse($httpResponse);
    } 

    /**
     * Create a response object.
     *
     * @param array $data The response data
     * @return TransactionResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new TransactionResponse($this, $data);
    }
}
