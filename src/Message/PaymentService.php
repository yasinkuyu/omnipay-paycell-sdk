<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Paycell\Message\HashService;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class PaymentService 
{
    private $prodBaseUrl = 'https://tpay.turkcell.com.tr/tpay/provision/services/restful/';
    private $prodPaymentBaseUrl = 'https://epayment.turkcell.com.tr/paymentmanagement/rest/';

    private $testBaseUrl = 'https://tpay-test.turkcell.com.tr:443/tpay/provision/services/restful/';
    private $testPaymentBaseUrl = 'https://omccstb.turkcell.com.tr/paymentmanagement/rest/';

    private $baseUrl;
    private $paymentBaseUrl;

    private $requestData = array();

    public function __construct($environment = 'prod')
    {
        if ($environment === 'prod') {
            $this->baseUrl = $this->prodBaseUrl;
            $this->paymentBaseUrl = $this->prodPaymentBaseUrl;
        } else {
            $this->baseUrl = $this->testBaseUrl;
            $this->paymentBaseUrl = $this->testPaymentBaseUrl;
        }

        $hashService = new HashService();
        $gateway = new \Omnipay\Paycell\Gateway();

        $transactionId = $gateway->getTransactionId();
        $transactionDateTime = $gateway->getTransactionDateTime();

        // Request hash'ini oluşturmak için HashService sınıfını kullanalım
        $requestHashData = $hashService->requestHash($transactionId, $transactionDateTime);
        
        // Response hash'ini oluşturmak için HashService sınıfını kullanalım
        $responseHashData = $hashService->responseHash(
            'transactionId',
            'responseDateTime',
            'responseCode',
            'cardToken'
        );
        
        $this->requestData = [
            "header" => [
                "applicationName" => $gateway->getApplicationName(),
                "transactionId" => $transactionId,
                "transactionDateTime" => $transactionDateTime
            ],
            "hashData" => $requestHashData
        ];

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
     * @param array $data
     * @return mixed
     */
    public function provision($data)
    {
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
        return $this->sendRequestPayment('getCardTokenSecure');
    }

    // 3D Redirect Page
    public function threeDSecure()
    {
        return $this->sendRequestPayment('threeDSecure');
    }

    private function sendRequest($endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;
       
        return array('url' => $url, 'data' => $this->requestData); // return response data
    }

    private function sendRequestPayment($endpoint, $data = [])
    {

        $url = $this->paymentBaseUrl . $endpoint;
  
        return array('url' => $url, 'data' => $this->requestData); // return response data
    }
}