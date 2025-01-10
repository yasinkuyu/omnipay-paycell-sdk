<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Paycell\Helpers\HashService;

/**
 *   Paycell Web SDK entegrasyonu için Paycell tarafından sağlanması gereken bilgiler;
 *
 *   Merchant Code
 *   Terminal Code
 *   Secure Code
 *   Application Name
 *   Application Password
 * 
 *   Paycell Web SDK’ya atacağınız requestleri göndereceğiniz URL’ler:
 *   https://websdktest.turkcell.com.tr/api/session/init
 *   https://websdktest.turkcell.com.tr/home/[trackingId]
 *   Paycell Web SDK, Init ve Status servislerinden meydana gelmektedir.
 *
 *   1. Init Servisi: Ödeme işlemi başlatılıp alınan tracking ID ile Paycell arayüzüne erişim sağlanır.
 *   2. Validation: Kullanıcının Paycell sistemine giriş yapıp ödemesini tamamlaması sağlanır.
 *   3. Status servisi: Başlatılan ödemenin son durumu hakkında sorgulama yapılır.
 * 
 *   Üye iş yeri, yapacağı SDK entegrasyonu ile Paycell servislerine erişim sağlamış olacaktır. Akış şu sırada ilerleyecektir.
 *
 *   - Üye iş yeri uygulamasında, doğrulanmış bir kullanıcı ödeme adımında “Turkcell Paycell ile Öde” butonuna basar.
 *   - Üye işyeri uygulaması “init” servisini çağırır. (https://websdktest.turkcell.com.tr/api/session/init )
 *   - Init servisi cevabında işlem başarılı olursa trackingID üretilir.
 *   - TrackingID bilgisi kullanılarak https://websdktest.turkcell.com.tr/home/[trackingId] linkin sonuna TrackingID eklenerek kullanıcı, sayfaya iframe içinde ya da yeni sekmede açılarak yönlendirilir.
 *   - Bu sayfanın yönlendirilmesi ile üye iş yeri, arka planda trackingID bilgisini kullanarak Status servisini çağırır ve işlemin sonucunu başarılı ya da başarısız olarak öğrenmek için sürekli sorgular.
 *   - Status’ten gelecek sonuç enum tipindedir. 0 için SUCCESS, 1 için PENDING, 2 için CANCELLED ve 3 için NOTFOUND değerlerinden biridir.
 *   - Sonucun alınması ile üye iş yeri sonuç bilgisini kullanıcıya gösterir.
 *
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */
abstract class PaycellService extends AbstractRequest
{

    // https://paycell.com.tr/paycell-sdk?q=querypaymentstatus

    public const PROD_INIT_URL = 'https://paycellsdk.paycell.com.tr/api/session/init';
    private const PROD_INIT_HOME_URL = 'https://paycellsdk.paycell.com.tr/home/[trackingId]';
    private const PROD_QUERY_URL = 'https://zone-ist.paycell.com.tr/tpay/zone/services/cancelrestful/cancelService/';

    private const TEST_INIT_URL = 'https://websdktest.turkcell.com.tr/api/session/init';
    private const TEST_INIT_HOME_URL = 'https://websdktest.turkcell.com.tr/home/[trackingId]';
    private const TEST_QUERY_URL = 'https://zone-test.turkcell.com.tr/tpay/zone/services/cancelrestful/cancelService/';

	public static $queryStatu = "queryPaymentStatus/";
	public static $reverse = "reversePayment/";
	public static $refund = "refundPayment/";
	public static $summaryReconciliation = "summaryReconciliation/";

    private $initUrl;
    private $initHomeUrl;
    private $queryUrl;

    private $requestData = [];

    /**
     * Sets the endpoint URLs based on the test mode.
     * 
     * This method sets the `$initUrl` and `$queryUrl` properties based on the value of the `$testMode` property. If `$testMode` is false, the production URLs are used. Otherwise, the test URLs are used.
     */
    public function getEndpoint(): void
    {
        if ($this->getTestMode() === false) {
            $this->initUrl = self::PROD_INIT_URL;
            $this->initHomeUrl = self::PROD_INIT_HOME_URL;
            $this->queryUrl = self::PROD_QUERY_URL;
        } else {
            $this->initUrl = self::TEST_INIT_URL;
            $this->initHomeUrl = self::TEST_INIT_HOME_URL;
            $this->queryUrl = self::TEST_QUERY_URL;
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
            "merchant" => array(
                "merchantCode" => $this->getMerchantCode(),
                "terminalCode" => $this->getTerminalCode(),
                "logos" => null,
            ),
            "transactionInfo" => array(
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId(),
            ),
            "applicationName" => $this->getApplicationName(),
            "applicationPassword" => $this->getApplicationPwd(),
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
        return $this->executeRequest($this->initUrl . $endpoint, $data);
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
        return $this->executeRequest($this->queryUrl . $endpoint, $data);
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
echo $url;
echo PHP_EOL;
print_r($data);
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

        $httpResponse = json_decode($httpResponse);

        if(isset($httpResponse->trackingId)){
            $httpResponse->trackingUrl = str_replace('[trackingId]', $httpResponse->trackingId, $this->initHomeUrl);
        }

        return $httpResponse;
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

        $requestHeader = $this->getRequestHeader();
        $paymentReferenceNumber = $requestHeader["transactionInfo"]["transactionId"];
        $returnUrl = str_replace("[paymentReferenceNumber]", $paymentReferenceNumber, $this->getReturnUrl());
        
        $hashService = new HashService([
            'secureCode' => $this->getSecureCode(),
            'terminalCode' => $this->getTerminalCode(),
            'paymentReferenceNumber' => $paymentReferenceNumber,
            'amount' => $this->getAmountInteger(),
            'paymentSecurity' => $this->getPaymentSecurity(),
            'hostAccount' => $this->getHostAccount(),
            'currency' => $this->getCurrency() === 'TRY' ? 99 : $this->getCurrency(),
            'installmentPlan' => $this->getInstallmentPlan()
        ]);

        $transactionDateTime = $requestHeader["transactionInfo"]["transactionDateTime"];
        $transactionId = $requestHeader["transactionInfo"]["transactionId"];

        $requestHashData = $hashService->generateRequestHash($transactionId, $transactionDateTime);

        $this->requestData = [
            "requestHeader" => $requestHeader,
            "hashData" => $requestHashData,
            "hostAccount" => $this->getHostAccount(), // Üye iş yeri uygulamasında ödemeyi yapan kullanıcıyı tekil olarak ifade eden değerdir. Üye işyeri uygulamasında kullanıcı doğrulaması mail adresi ile yapılıyorsa bu alanda mail adresi gönderilebilir.
            "language" => $this->getLanguage(), // tr or en
            "payment" => array(
                "amount" => $this->getAmountInteger(),
                "currency" => $this->getCurrency() === 'TRY' ? 99 : $this->getCurrency(),
                "paymentReferenceNumber" => $paymentReferenceNumber,
                "paymentSecurity" => $this->getPaymentSecurity(), // THREED_SECURE
                "installmentPlan" => $this->getInstallmentPlan(),
            ),
            "returnUrl" => $returnUrl, // ReturnUrl, ödeme işlemi gerçekleştikten sonra kullanıcıyı üye işyerine yönlendirecek URL’yi içerir. Ödeme işlemi tamamlandığında sdk tarafından returnUrl ’e redirect  yapılır. Bu url dinlenerek status servis sorgulanmadan işlemin bittiği anlaşılabilir.
            "postResultUrl" => $this->getPostResultUrl(), // Bu URL’e işlem başarılı , başarısız olarak tamamlandığında veya timeout alıdığında Paycell WEB SDK tarafından ödemeye ait bilgi ve statü post edilir. Burada gleen bilgiler Üye işyeri tarafından yorumlanarak aksiyon alınabilir.
            "timeoutDuration" => 600000, // 600000, // Üye işyerinin alışveriş için verdiği toplam zamandır
        ];
 
        return $this->sendRequest('', $data);
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
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId(),
            ],
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getPrefix() . $this->getTransactionId(),
            "originalReferenceNumber" => $this->getOriginalReferenceNumber(),
        ];

        return $this->sendRequestPayment('reversePayment/', $data);
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
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId(),
            ],
            "merchantCode" => $this->getMerchantCode(),
            "msisdn" => $this->getMsisdn(),
            "referenceNumber" => $this->getPrefix() . $this->getTransactionId(),
            "originalReferenceNumber" => $this->getOriginalReferenceNumber(),
            "originalPaymentReferenceNumber" => $this->getOriginalPaymentReferenceNumber(),
            "amount" => $this->getAmountInteger(),
        ];

        return $this->sendRequestPayment('refundPayment/', $data);
    }

    /**
     * Query a payment.
     *
     * @param array $data
     * @return mixed
     */
    public function query(array $data)
    {

        $this->requestData = [
            "originalPaymentReferenceNumber" => $this->getOriginalPaymentReferenceNumber(),
            "merchantCode" => $this->getMerchantCode(),
            "requestHeader" => [
                "applicationName" => $this->getApplicationName(),
                "applicationPwd" => $this->getApplicationPwd(),
                "clientIPAddress" => $this->getClientIPAddress(),
                "transactionDateTime" => $this->getTransactionDateTime(),
                "transactionId" => $this->getTransactionId(),
            ],
        ];

        return $this->sendRequestPayment('queryPaymentStatus/', $data);
    }

    /**
     * Get summary reconciliation.
     *
     * @return mixed
     */
    public function summaryReconciliation()
    {
        return $this->sendRequestPayment('summaryReconciliation/');
    }
 
}
