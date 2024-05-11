<?php
namespace Omnipay\Paycell\Message;

use Omnipay\Paycell\Gateway;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
/**
 * HashService class for generating hash data for Paycell requests.
 */
class HashService {
 
    /**
     * Generates hash data for the request.
     *
     * @param string $transactionId The transaction ID.
     * @param string $transactionDateTime The transaction date and time.
     * @return string The generated hash data.
     */
    public function requestHash($transactionId, $transactionDateTime): string {
        return $this->generateHash($transactionId, $transactionDateTime);
    }

    /**
     * Generates hash data for the response.
     *
     * @param string $transactionId The transaction ID.
     * @param string $responseDateTime The response date and time.
     * @param string $responseCode The response code.
     * @param string $cardToken The card token.
     * @return string The generated hash data.
     */
    public function responseHash($transactionId, $responseDateTime, $responseCode, $cardToken): string {
        return $this->generateHash($transactionId, $responseDateTime, $responseCode, $cardToken);
    }

    /**
     * Generates hash data based on given parameters.
     *
     * @param string $transactionId The transaction ID.
     * @param string $dateTime The date and time.
     * @param string|null $responseCode The response code.
     * @param string|null $cardToken The card token.
     * @return string The generated hash data.
     */
    private function generateHash($transactionId, $dateTime, $responseCode = null, $cardToken = null): string {
        // Get necessary parameters from the gateway
        $gateway = new Gateway();
        $applicationName = $gateway->getApplicationName();
        $applicationPwd =  $gateway->getApplicationPwd();
        $secureCode = $gateway->getSecureCode();

        // Generate security data and hash it
        $securityData = $this->hash($applicationPwd.$applicationName);
        $hashData = $this->hash(
            $applicationName.
            $transactionId.
            $dateTime.
            ($responseCode ?? '') .
            ($cardToken ?? '') .
            $secureCode .
            $securityData
        );

        return $hashData;
    }

    /**
     * Hashes the given parameter.
     *
     * @param string $param The parameter to hash.
     * @return string The hashed data.
     */
    private function hash($param): string {
        $upper = strtoupper($param);
        return base64_encode(hash('sha256', $upper, true));
    }
}
