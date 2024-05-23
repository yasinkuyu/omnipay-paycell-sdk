<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Omnipay\Paycell\Helpers\HashService;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
abstract class AbstractPayment extends OmnipayAbstractRequest  
{

    private $prodBaseUrl = 'https://tpay.turkcell.com.tr/tpay/provision/services/restful/';
    private $prodPaymentBaseUrl = 'https://epayment.turkcell.com.tr/paymentmanagement/rest/';

    private $testBaseUrl = 'https://tpay-test.turkcell.com.tr:443/tpay/provision/services/restful/';
    private $testPaymentBaseUrl = 'https://omccstb.turkcell.com.tr/paymentmanagement/rest/';

    private $baseUrl;
    private $paymentBaseUrl;

    private $requestData = array();

    // abstract protected function createResponse($data);

    public function getEndpoint()
    {
        if ($this->getTestMode() == false) {
            $this->baseUrl = $this->prodBaseUrl;
            $this->paymentBaseUrl = $this->prodPaymentBaseUrl;
        } else {
            $this->baseUrl = $this->testBaseUrl;
            $this->paymentBaseUrl = $this->testPaymentBaseUrl;
        }
    }
  
    // Provision Services
    /**
     * Get cards information.
     *
     * @return mixed
     */
    public function getCards()
    {
        return $this->sendRequest('getCardToken/getCards/');
    }

    /**
     * Register a new card.
     *
     * @return mixed
     */
    public function registerCard()
    {
        return $this->sendRequest('getCardToken/registerCard/');
    }

    /**
     * Update card information.
     *
     * @return mixed
     */
    public function updateCard()
    {
        return $this->sendRequest('getCardToken/updateCard/');
    }

    /**
     * Delete card information.
     *
     * @return mixed
     */
    public function deleteCard()
    {
        return $this->sendRequest('getCardToken/deleteCard/');
    }

    /**
     * Provision a payment.
     * 
     * Kart numarası girilerek yapılan 3D doğrulama olmadan ödeme: getCardTokenSecure + provision
     * Kart numarası girilerek yapılan 3D doğrulama ile ödeme: getCardTokenSecure + (getThreeDSession + provision)
     * 
     * Servis inputunda yer alan hashdata oluşturulmasında kullanılan parametreler “backend” tarafında tutulmalı ve hashdata “backend” 
     * üzerinde oluşturularak uygulama/client’a bildirilmelidir. getCardTokenSecure servisi doğrudan uygulama/client tarafından ilgili 
     * parametreler ile çağrılmalıdır. 
     * Implementasyon kullanıcı arayüzü olarak web sayfası kullanıyorsa cross-origin hatasının alınmasınının engellenmesi için 
     * üye işyeri domain bilgileri Paycell’e iletilmelidir ve Paycell’de yetki tanımlaması yapılmalıdır. Kullanıcı arayüzü mobil uygulama 
     * için herhangi bir tanıma gerek bulunmamaktadır.
     * 
     * @param array $data
     * @return mixed
     */
    public function provision($data)
    {

        $this->validate( 'card');

        $card = $this->getCard();
        
        $this->requestData = [
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId()
            ],

            "amount" => $this->getAmountInteger(),
            "currency" => $this->getCurrency(),

            'paymentSecurity' => 'THREED_SECURE', // THREED_SECURE or NON_THREED_SECURE
            "paymentType" => $this->actionType,
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "merchantCode" => $this->getMerchantCode(),
            
        ];
 
        return $this->sendRequest('getCardToken/provision/', $data);
    }

    /**
     * Inquire about a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function inquire($data)
    {
        return $this->sendRequest('getCardToken/inquire/', $data);
    }

    /**
     * Reverse a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function reverse($data)
    {
        return $this->sendRequest('getCardToken/reverse/', $data);
    }

    /**
     * Refund a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function refund($data)
    {
        return $this->sendRequest('getCardToken/refund/', $data);
    }

    /**
     * Get summary reconciliation.
     *
     * @return mixed
     */
    public function summaryReconciliation()
    {
        return $this->sendRequest('getCardToken/summaryReconciliation/');
    }

    /**
     * Get 3D secure session.
     *
     * @param array $data
     * @return mixed
     */
    public function getThreeDSession($data)
    {
        
        $this->requestData = [
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId()
            ],

            "amount" => $this->getAmountInteger(),
            "currency" => $this->getCurrency(),
            "installmentCount" => null, // null required

            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => null, // null required
            "target" => 'MERCHANT', 
            "transactionType" => 'AUTH', 

        ];
 
        return $this->sendRequest('getCardToken/getThreeDSession/', $data);
    }

    /**
     * Get 3D secure session result.
     *
     * @param array $data
     * @return mixed
     */
    public function getThreeDSessionResult($data)
    {

        $this->requestData = [
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId()
            ],

            "amount" => $this->getAmountInteger(),
            "currency" => $this->getCurrency(),
            "installmentCount" => null, // null required

            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => null, // null required
            "target" => 'MERCHANT', 
            "transactionType" => 'AUTH', 

        ];
 
 
        return $this->sendRequest('getCardToken/getThreeDSessionResult/', $data);
    }

    /**
     * Get provision history.
     *
     * @param array $data
     * @return mixed
     */
    public function getProvisionHistory($data)
    {
        return $this->sendRequest('getCardToken/getProvisionHistory/', $data);
    }

    /**
     * Provision for Marketplace.
     *
     * @param array $data
     * @return mixed
     */
    public function provisionForMarketPlace($data)
    {
        return $this->sendRequest('getCardToken/provisionForMarketPlace/', $data);
    }

    /**
     * Get terms of service content.
     *
     * @return mixed
     */
    public function getTermsOfServiceContent()
    {
        return $this->sendRequest('getCardToken/getTermsOfServiceContent/');
    }

    /**
     * Get card BIN information.
     *
     * @param array $data
     * @return mixed
     */
    public function getCardBinInformation($data)
    {
        return $this->sendRequest('getCardToken/getCardBinInformation/', $data);
    }

    /**
     * Get payment methods.
     *
     * @return mixed
     */
    public function getPaymentMethods()
    {
        return $this->sendRequest('getCardToken/getPaymentMethods/');
    }

    /**
     * Open mobile payment.
     *
     * @param array $data
     * @return mixed
     */
    public function openMobilePayment($data)
    {
        return $this->sendRequest('getCardToken/openMobilePayment/', $data);
    }

    /**
     * Send OTP (One Time Password).
     *
     * @param array $data
     * @return mixed
     */
    public function sendOTP($data)
    {
        return $this->sendRequest('getCardToken/sendOTP/', $data);
    }

    /**
     * Validate OTP (One Time Password).
     *
     * @param array $data
     * @return mixed
     */
    public function validateOTP($data)
    {
        return $this->sendRequest('getCardToken/validateOTP/', $data);
    }

    /**
     * Provision all.
     *
     * @param array $data
     * @return mixed
     */
    public function provisionAll($data)
    {
        return $this->sendRequest('getCardToken/provisionAll/', $data);
    }

    /**
     * Inquire all.
     *
     * @param array $data
     * @return mixed
     */
    public function inquireAll($data)
    {
        return $this->sendRequest('getCardToken/inquireAll/', $data);
    }

    /**
     * Refund all.
     *
     * @param array $data
     * @return mixed
     */
    public function refundAll($data)
    {
        return $this->sendRequest('getCardToken/refundAll/', $data);
    }
 
    // Payment Management
    /*
        getCardTokenSecure
        Kart numarası girilerek yapılan işlemlerde öncelikle kart bilgilerine ait token değeri alınmalıdır. Alınan token değeri, gerçekleştirilmesi istenen işlem tipi için çağrılan servise input olarak eklenmelidir. getCardTokenSecure çağrılarak alınan token değerinin input olarak kullanıldığı işlemler aşağıdaki gibidir.
            - Kart ekleme 3D doğrulama olmadan: getCardTokenSecure + registerCard
            - Kart ekleme 3D doğrulama ile: getCardTokenSecure + (getThreeDSession + registerCard)
            - Kart numarası girilerek yapılan 3D doğrulama olmadan ödeme: getCardTokenSecure + provision

        Kart numarası girilerek yapılan 3D doğrulama ile ödeme: getCardTokenSecure + (getThreeDSession + provision)
        Servis inputunda yer alan hashdata oluşturulmasında kullanılan parametreler “backend” tarafında tutulmalı ve hashdata “backend” üzerinde oluşturularak uygulama/client’a bildirilmelidir. getCardTokenSecure servisi doğrudan uygulama/client tarafından ilgili parametreler ile çağrılmalıdır.
        Implementasyon kullanıcı arayüzü olarak web sayfası kullanıyorsa cross-origin hatasının alınmasınının engellenmesi için üye işyeri domain bilgileri Paycell’e iletilmelidir ve Paycell’de yetki tanımlaması yapılmalıdır. Kullanıcı arayüzü mobil uygulama için herhangi bir tanıma gerek bulunmamaktadır.
        requestParameters
        requestHeader
    */
    public function getCardTokenSecure()
    {
        $this->validate( 'card');

        $hashService = new HashService();

        $transactionDateTime =  $this->getTransactionDateTime();
        $transactionId = $this->getTransactionId();

        $requestHashData = $hashService->requestHash($transactionId, $transactionDateTime);
        
        $card = $this->getCard();

        $this->requestData = [
            "header" => [
                "applicationName" =>  $this->getApplicationName(),
                "transactionId" => $transactionId,
                "transactionDateTime" => $transactionDateTime
            ],
            "hashData" => $requestHashData,

            "creditCardNo" => $card->getNumber(),
            "expireDateMonth" => $card->getExpiryDate('m'),
            "expireDateYear" => $card->getExpiryDate('Y'),
            "cvcNo" => $card->getCvv()
        ];


        return $this->sendRequestPayment('getCardTokenSecure');
    }

    // 3D Redirect Page
    public function threeDSecure($data)
    {
        $this->requestData = [
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId()
            ],

            "amount" => $this->getAmountInteger(),
            "currency" => $this->getCurrency(),
            "installmentCount" => null, // null required

            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => null, // null required
            "target" => 'MERCHANT', 
            "transactionType" => 'AUTH', 

        ];
        return $this->sendRequestPayment2('threeDSecure', $data);
    }
   
    private function sendRequest($endpoint, $data = [])
    {
        $this->getEndpoint();
        return $this->executeRequest($this->baseUrl . $endpoint, $data);
    }
    
    private function sendRequestPayment($endpoint, $data = [])
    {
        $this->getEndpoint();
        return $this->executeRequest($this->paymentBaseUrl . $endpoint, $data);
    }
    
    private function sendRequestPayment2($endpoint, $data = [])
    {
        $this->getEndpoint();
        return $this->executeRequest2($this->paymentBaseUrl . $endpoint, $data);
    }
    
    private function executeRequest($url, $data)
    {
        $data = array_merge($data, $this->requestData);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ]);

        $httpResponse = curl_exec($curl);

        curl_close($curl);
    
        return json_decode($httpResponse);
    }

    private function executeRequest2($url, $data)
    {
        // $data = array_merge($data, $this->requestData);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ]);

        $httpResponse = curl_exec($curl);

        curl_close($curl);
    
        return $httpResponse;
    }
}