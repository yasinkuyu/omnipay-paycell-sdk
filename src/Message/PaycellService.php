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
     * 
     * This method sets the `$baseUrl` and `$paymentBaseUrl` properties based on the value of the `$testMode` property. If `$testMode` is false, the production URLs are used. Otherwise, the test URLs are used.
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
     * Returns the request header for the Paycell service.
     *
     * The request header includes the following information:
     * - Application name
     * - Application password
     * - Client IP address
     * - Transaction date and time
     * - Transaction ID
     *
     * @return array An associative array containing the request header information.
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
     * This method is responsible for executing a CURL request to the specified URL with the provided data. It sets up the CURL options, sends the request, and returns the decoded JSON response.
     *
     * @param string $url The URL to send the CURL request to.
     * @param array $data An associative array of data to be sent in the request body.
     * @return mixed The decoded JSON response from the CURL request.
     * @throws \Exception If the CURL request fails or the response is empty.
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
     * This method is used to provision a payment transaction. It sends a request to the Paycell service to provision the payment, using the provided data.
     *
     * @param array $data An associative array containing the necessary data for the provision payment request, such as the card ID, merchant code, MSISDN, reference number, amount, payment type, acquirer bank code, and 3D session ID.
     * @return mixed The response from the Paycell service for the provision payment request.
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
     * This method is used to reverse a previous payment transaction. It sends a request to the Paycell service to reverse the payment, using the provided data.
     *
     * @param array $data An associative array containing the necessary data for the reverse payment request, such as the amount, merchant code, MSISDN, reference number, original reference number, payment type, acquirer bank code, and 3D session ID.
     * @return mixed The response from the Paycell service for the reverse payment request.
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
     * This method is used to refund a previous payment transaction. It sends a request to the Paycell service to refund the payment, using the provided data.
     *
     * @param array $data An associative array containing the necessary data for the refund payment request, such as the amount, merchant code, MSISDN, reference number, and original reference number.
     * @return mixed The response from the Paycell service for the refund payment request.
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
     * This method is used to get a 3D secure session for a payment transaction. It sends a request to the Paycell service to initiate the 3D secure session, using the provided data.
     *
     * @param array $data An associative array containing the necessary data for the 3D secure session request, such as the amount, merchant code, MSISDN, and transaction type.
     * @return mixed The response from the Paycell service for the 3D secure session request.
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
     * This method is used to get the result of a 3D secure session for a payment transaction. It sends a request to the Paycell service to retrieve the 3D secure session result, using the provided data.
     *
     * @param array $data An associative array containing the necessary data for the 3D secure session result request, such as the amount, currency, merchant code, MSISDN, reference number, and transaction type.
     * @return mixed The response from the Paycell service for the 3D secure session result request.
     */
    public function getThreeDSessionResult()
    {
        $this->requestData = [
            "requestHeader" => $this->getRequestHeader(),
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "threeDSessionId" =>  $this->getThreeDSessionId(),
        ];

        if ($this->getInstallment() > 0) {
            $this->requestData['installmentCount'] = $this->getInstallment();
        }

        return $this->sendRequest('getCardToken/getThreeDSessionResult/', []);
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
     * Get a secure card token.
     *
     * This method validates the credit card information, retrieves the card details, and sends a request to the payment gateway to get a secure card token.
     *
     * @param string $requestHashData The hash data required for the secure card token request.
     * @return mixed The response from the secure card token request.
     */
    public function getCardTokenSecure(string $requestHashData, $transactionId, $transactionDateTime)
    {
        $this->validate('card');

        $card = $this->getCard();

        $this->requestData = [
            "header" => [
                "applicationName" => $this->getApplicationName(),
                "transactionId" => $transactionId,
                "transactionDateTime" => $transactionDateTime,
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
     * Performs a 3D Secure redirect for a payment transaction.
     *
     * @param array $data An array of data required for the 3D Secure redirect, such as payment details.
     * @return mixed The response from the 3D Secure redirect request.
     */
    public function threeDSecure(array $data)
    {
        $data['callbackurl'] = $this->getReturnUrl() . "?" . http_build_query([
            'sessionToken' => bin2hex(random_bytes(100)),
            'threeDSessionId' => $data['threeDSessionId'],
            'msisdn' => $this->getMsisdn()
        ]);

        $this->getEndpoint();

        $url = $this->paymentBaseUrl . "threeDSecure";
 
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
