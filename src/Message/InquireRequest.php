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
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */

class InquireRequest extends AbstractRequest
{

    use CommonParameters;

    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->inquire($data);

        return $this->createResponse($httpResponse);
    }

    protected function createResponse($data)
    {
        return $this->response = new TransactionResponse($this, $data);
    }
}
