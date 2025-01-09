<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell Refund
 * 
 * Yapılan ödeme işleminin iade edilmesi amacıyla kullanılır. İade, işlemin günsonu ardından 
 * ertesi günden itibaren iptal edilemesi veya belirli bir tutarın iade edilmesi amacıyla kullanılır. 
 * İptal işlemi iki şekilde çağırabilir. Provision servisine cevap alınamayarak timeout alınması durumunda, 
 * işlem mutabakatının sağlanması amacıyla şayet günsonu olmuş ise sistem tarafından refund gönderilebilir. 
 * Müşterinin iade talebi olması durumunda üye işyeri tarafından manuel olarak çağrılabilir. 
 * İade işlemi birden fazla sayıda çağrılabilir, iptal edilmiş bir işlem için iade işlemi gerçekleştirilemez, 
 * toplam iade tutarı işlem tutarının üzerinde olamaz.

 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */

class RefundRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->refund($data);
        return $this->createResponse($httpResponse);
    } 

    protected function createResponse($data)
    {
        return $this->response = new TransactionResponse($this, $data);
    }
}
