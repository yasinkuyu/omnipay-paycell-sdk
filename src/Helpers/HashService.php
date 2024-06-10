<?php
namespace Omnipay\Paycell\Helpers;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class HashService {

    public $applicationName;
    public $applicationPwd;
    public $secureCode;
    
    /**
     * Generates hash data for the request.
     * 
     * PAYCELL tarafından iletilecek applicationPwd ve secureCode ile input parametreleri hash’lenir.
     * Hash data oluşturulmasında kullanılacak olan güvenlik parametreleri (applicationName, applicationPwd, secureCode)
     *  server tarafında tutulmalıdır,
     * hash oluşturma işlemi server tarafında yapılmalıdır, ancak oluşan değerler uygulama/client tarafında iletilerek 
     * getCardTokenSecure servisi uygulama/client tarafından çağrılmalıdır.
     * hashData 2 aşamada oluşturulacaktır.
     * Her iki aşamada da ilgili parametreler büyük harfe dönüştürülerek data oluşturulmalıdır.
     * İlk aşamada securityData hashlenerek oluşturulur. securityData oluşturulurken applicationName ve applicationPwd değeri büyük harfe çevrilir. 
     * Oluşan securityData değeri ikinci aşamadaki hashData üretiminde kullanılmak üzere büyük harfe dönüştürülür.
     * İkinci aşamada, oluşturulan securityData ile diğer değerler büyük harfe çevrilerek birleştirilip elde edilen
     *  değer hashlenerek hashData oluşturulur.
     * securityData: applicationPwd+ applicationName
     * hashData: applicationName+ transactionId+ transactionDateTime+ secureCode + securityData
     * Java hash örneği aşağıdaki gibidir.
     * java.security.MessageDigest sha2 = java.security.MessageDigest.getInstance(“SHA-256”);
     * hash = Base64.encodeBase64String(sha2.digest(paramsVal.getBytes()));
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
     * responseBody’de dönülen hashData ile üye işyerinin oluşturacağı hashData eşit olmalıdır. Bu kontrol üye işyeri tarafından yapılır.
     * Üye işyerinin oluşturacağı hashData 2 aşamada oluşturulacaktır. İlk aşamada securityData hashlenerek oluşturulur. 
     * İkinci aşamada oluşturulan securityData ile diğer değerler birleştirilerek elde edilen değer hashlenerek hashData oluşturulur.
     * securityData: applicationPwd+ applicationName
     *   
     * hashData: applicationName+ transactionId+ responseDateTime + responseCode + cardToken + secureCode + securityData
     * Java hash örneği aşağıdaki gibidir.
     * java.security.MessageDigest sha2 = java.security.MessageDigest.getInstance(“SHA-256”);
     * hash = Base64.encodeBase64String(sha2.digest(paramsVal.getBytes()));
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
        $applicationName = $this->applicationName;
        $applicationPwd =  $this->applicationPwd;
        $secureCode = $this->secureCode;

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
