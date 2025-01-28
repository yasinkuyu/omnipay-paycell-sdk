<?php

namespace Omnipay\PaycellSDK\Message;
 
use Omnipay\PaycellSDK\CommonParameters;

/**
 * Paycell SDK Reverse Request
 * 
 * Yapılan ödeme işleminin iptal edilmesi amacıyla kullanılır. İptal işlemi iki şekilde çağırabilir. 
 * Provision servisine cevap alınamayarak timeout alınması durumunda, işlem mutabakatının sağlanması 
 * amacıyla sistem tarafından reverse gönderilebilir. Müşterinin iptal talebi olması durumunda üye işyeri 
 * tarafından manuel olarak çağrılabilir.
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
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
        return $this->response = new QueryResponse($this, $data);
    }
}
