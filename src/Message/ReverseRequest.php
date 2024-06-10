<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell Reverse
 * 
 * Yapılan ödeme işleminin iptal edilmesi amacıyla kullanılır. İptal işlemi iki şekilde çağırabilir. 
 * Provision servisine cevap alınamayarak timeout alınması durumunda, işlem mutabakatının sağlanması 
 * amacıyla sistem tarafından reverse gönderilebilir. Müşterinin iptal talebi olması durumunda üye işyeri 
 * tarafından manuel olarak çağrılabilir.
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */

/* 
    Example 
    Request:
    {
        "requestHeader":    {
            "applicationName": "XXXX",
            "applicationPwd": "XXXX",
            "clientIPAddress": "10.252.187.81",
            "transactionDateTime": "20160309084056197",
            "transactionId": "12345678901234567893"
        },
        "cardId": "e14fa3bc-82df-4086-bae2-664b77ae8692",
        "merchantCode": "9998",
        "msisdn": "5380521479",
        "referenceNumber": "12333374401234666892",
        "originalReferenceNumber": "12333374401234667882",
        "amount": "2351",
        "paymentType": "SALE",
        "acquirerBankCode": "111",
        "threeDSessionId": " "
    }    
    Response:
    {
        "responseHeader":    {
            "transactionId": "12345678901234567893",
            "responseDateTime": "20181101101959745",
            "responseCode": "0",
            "responseDescription": "Success"
        },
        "reconciliationDate": "20181101",
        "approvalCode": "575533",
        "retryStatusCode": null,
        "retryStatusDescription": null
    }  
 */
class ReverseRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->reverse($data);

        return $this->createResponse($httpResponse);
    }

    protected function createResponse($data)
    {
        return $this->response = new TransactionResponse($this, $data);
    }
}
