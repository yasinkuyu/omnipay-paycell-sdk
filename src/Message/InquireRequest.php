<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell Inquire
 * 
 * Yapılan ödemenin işlem sonucunun sorgulanması amacıyla kullanılır. 
 * Provision servisi senkron olarak işlem sonucunu dönmektedir, ancak provision
 * servisine herhangi bir teknik arıza sebebiyle cevap dönülememesi sonrasında işlem timeout’a düştüğünde
 * işlemin sonucu inquire ile sorgulanabilir. inquire servisi yapılan işleme ilişkin işlemin son durumunu ve
 * işlemin tarihçe bilgisini iletir.
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */

/* 
    Example 
    Request:
    {
        "merchantCode": "2001",
        "msisdn": "905591111112",
        "originalReferenceNumber": "12345678901234567891",
        "referenceNumber": "12345678901234567892",
        "requestHeader":    {
            "applicationName": "XXXX",
            "applicationPwd": "XXXX",
            "clientIPAddress": "10.252.187.81",
            "transactionDateTime": "20160309112423228",
            "transactionId": "12345678901234567890"
        }
    }      
    Response:
    {
        "responseHeader":    {
            "transactionId": "12345678901234567890",
            "responseDateTime": "20181017131815713",
            "responseCode": "0",
            "responseDescription": "Success"
        },
        "orderId": "926197750916112311250814",
        "acquirerBankCode": "046",
        "status": "REVERSE",
        "provisionList":    [
                    {
                "provisionType": "REVERSE",
                "transactionId": "12345678901234567890",
                "amount": "2351",
                "approvalCode": "478341",
                "dateTime": "20161123125420528",
                "reconciliationDate": "20161123",
                "responseCode": "",
                "responseDescription": ""
            },
                    {
                "provisionType": "SALE",
                "transactionId": "12345678901234567890",
                "amount": "2351",
                "approvalCode": "478341",
                "dateTime": "20161123112507261",
                "reconciliationDate": "20161123",
                "responseCode": "",
                "responseDescription": ""
            }
        ]
    }     
 */

class InquireRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->inquire($data);

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
