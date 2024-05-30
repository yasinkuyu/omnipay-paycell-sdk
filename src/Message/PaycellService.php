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
abstract class PaycellService extends AbstractRequest
{
    private const PROD_BASE_URL = 'https://tpay.turkcell.com.tr/tpay/provision/services/restful/';
    private const PROD_PAYMENT_BASE_URL = 'https://epayment.turkcell.com.tr/paymentmanagement/rest/';

    private const TEST_BASE_URL = 'https://tpay-test.turkcell.com.tr:443/tpay/provision/services/restful/';
    private const TEST_PAYMENT_BASE_URL = 'https://omccstb.turkcell.com.tr/paymentmanagement/rest/';

    private $baseUrl;
    private $paymentBaseUrl;

    private $requestData = [];

    /**
     * Sets the endpoint URLs based on the test mode.
     */
    public function getEndpoint(): void
    {
        if ($this->getTestMode() === false) {
            $this->baseUrl = self::PROD_BASE_URL;
            $this->paymentBaseUrl = self::PROD_PAYMENT_BASE_URL;
        } else {
            $this->baseUrl = self::TEST_BASE_URL;
            $this->paymentBaseUrl = self::TEST_PAYMENT_BASE_URL;
        }
    }

    /**
     * Returns the request header.
     *
     * @return array
     */
    private function getRequestHeader(): array
    {
        return [
            "applicationName" => $this->getApplicationName(),
            "applicationPwd" => $this->getApplicationPwd(),
            "clientIPAddress" => $this->getClientIPAddress(),
            "transactionDateTime" => $this->getTransactionDateTime(),
            "transactionId" => $this->getTransactionId()
        ];
    }

    /**
     * Sends a request to the given endpoint.
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    private function sendRequest(string $endpoint, array $data = [])
    {
        $this->getEndpoint();
        return $this->executeRequest($this->baseUrl . $endpoint, $data);
    }

    /**
     * Sends a payment request to the given endpoint.
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    private function sendRequestPayment(string $endpoint, array $data = [])
    {
        $this->getEndpoint();
        return $this->executeRequest($this->paymentBaseUrl . $endpoint, $data);
    }

    /**
     * Executes a CURL request to the given URL with the provided data.
     *
     * @param string $url
     * @param array $data
     * @return mixed
     */
    private function executeRequest(string $url, array $data)
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

        if ($httpResponse === false) {
            throw new \Exception("cURL request failed: " . curl_error($curl));
        }

        curl_close($curl);

        if (empty($httpResponse)) {
            throw new \Exception("Empty response received from cURL request");
        }

        return json_decode($httpResponse);
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
    public function provision(array $data)
    {
        $this->validate('card');

        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "cardId" => $this->getCardId(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "amount" => $this->getAmountInteger(),
            "paymentType" => $this->actionType,
            "acquirerBankCode" => $this->getAcquirerBankCode(),
            "threeDSessionId" => $this->getThreeDSessionId(),
        ];

        return $this->sendRequest('getCardToken/provision/', $data);
    }

    /**
     * Inquire about a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function inquire(array $data)
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "originalReferenceNumber" => $this->getOriginalReferenceNumber(),
        ];

        return $this->sendRequest('getCardToken/inquire/', $data);
    }

    /**
     * Reverse a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function reverse(array $data)
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "amount" => $this->getAmountInteger(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "originalReferenceNumber" => $this->getOriginalReferenceNumber(),
            "paymentType" => $this->actionType,
            "acquirerBankCode" => $this->getAcquirerBankCode(),
            "threeDSessionId" => $this->getThreeDSessionId(),
        ];

        return $this->sendRequest('getCardToken/reverse/', $data);
    }

    /**
     * Refund a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function refund(array $data)
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "amount" => $this->getAmountInteger(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "originalReferenceNumber" => $this->getOriginalReferenceNumber(),
        ];

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
    public function getThreeDSession(array $data)
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "amount" => $this->getAmountInteger(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "target" => 'MERCHANT',
            "transactionType" => 'AUTH',
        ];

        if ($this->getInstallment() > 0) {
            $this->requestData['installmentCount'] = $this->getInstallment();
        }

        return $this->sendRequest('getCardToken/getThreeDSession/', $data);
    }

    /**
     * Get 3D secure session result.
     *
     * @param array $data
     * @return mixed
     */
    public function getThreeDSessionResult(array $data)
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "amount" => $this->getAmountInteger(),
            "currency" => $this->getCurrency(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getReferenceNumber(),
            "target" => 'MERCHANT',
            "transactionType" => 'AUTH',
        ];

        if ($this->getInstallment() > 0) {
            $this->requestData['installmentCount'] = $this->getInstallment();
        }

        return $this->sendRequest('getCardToken/getThreeDSessionResult/', $data);
    }

    /**
     * Get provision history.
     *
     * @param array $data
     * @return mixed
     */
    public function getProvisionHistory(array $data)
    {
        return $this->sendRequest('getCardToken/getProvisionHistory/', $data);
    }

    /**
     * Provision for Marketplace.
     *
     * @param array $data
     * @return mixed
     */
    public function provisionForMarketPlace(array $data)
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
    public function getCardBinInformation(array $data)
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
    public function openMobilePayment(array $data)
    {
        return $this->sendRequest('getCardToken/openMobilePayment/', $data);
    }

    /**
     * Send OTP (One Time Password).
     *
     * @param array $data
     * @return mixed
     */
    public function sendOTP(array $data)
    {
        return $this->sendRequest('getCardToken/sendOTP/', $data);
    }

    /**
     * Validate OTP (One Time Password).
     *
     * @param array $data
     * @return mixed
     */
    public function validateOTP(array $data)
    {
        return $this->sendRequest('getCardToken/validateOTP/', $data);
    }

    /**
     * Provision all.
     *
     * @param array $data
     * @return mixed
     */
    public function provisionAll(array $data)
    {
        return $this->sendRequest('getCardToken/provisionAll/', $data);
    }

    /**
     * Inquire all.
     *
     * @param array $data
     * @return mixed
     */
    public function inquireAll(array $data)
    {
        return $this->sendRequest('getCardToken/inquireAll/', $data);
    }

    /**
     * Refund all.
     *
     * @param array $data
     * @return mixed
     */
    public function refundAll(array $data)
    {
        return $this->sendRequest('getCardToken/refundAll/', $data);
    }

    /**
     * Get card token securely.
     *
     * @param string $requestHashData
     * @return mixed
     */
    public function getCardTokenSecure(string $requestHashData)
    {
        $this->validate('card');

        $card = $this->getCard();

        $this->requestData = [
            "header" => [
                "applicationName" => $this->getApplicationName(),
                "transactionId" => $this->getTransactionId(),
                "transactionDateTime" => $this->getTransactionDateTime(),
            ],
            "hashData" => $requestHashData,
            "creditCardNo" => $card->getNumber(),
            "expireDateMonth" => $card->getExpiryDate('m'),
            "expireDateYear" => $card->getExpiryDate('Y'),
            "cvcNo" => $card->getCvv(),
        ];

        return $this->sendRequestPayment('getCardTokenSecure');
    }

    /**
     * 3D Secure redirect page.
     *
     * @param array $data
     * @return mixed
     */
    public function threeDSecure(array $data)
    {
        $this->requestData = [
            "callbackUrl" => $this->getReturnUrl(),
        ];

        $this->getEndpoint();

        $url = $this->paymentBaseUrl . "threeDSecure";
        $data = array_merge($data, $this->requestData);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
            ],
        ]);

        $httpResponse = curl_exec($curl);

        if ($httpResponse === false) {
            throw new \Exception("cURL request failed: " . curl_error($curl));
        }

        curl_close($curl);

        if (empty($httpResponse)) {
            throw new \Exception("Empty response received from cURL request");
        }

        return $httpResponse;
    }
}
