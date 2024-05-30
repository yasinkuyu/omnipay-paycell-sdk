<?php

// print_r($_POST);
// getThreeDSessionResult
// cardToken -> provision 
// purchase adımlarını tekrar başlat

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20
$gateway->setReferenceNumber(date("Ymdhissss")); // unique transaction reference number, order number etc... 
 
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '5406675406675403',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '000' 
    ],
])->send();

if ($response->isSuccessful()) {

    echo "Payment Successful" . PHP_EOL;

    echo PHP_EOL;

    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
    echo "ReferenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;

    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getExtraParameters: " . $response->getExtraParameters() . PHP_EOL;
    echo "getOrderId: " . $response->getOrderId() . PHP_EOL;
    echo "getAcquirerBankCode: " . $response->getAcquirerBankCode() . PHP_EOL;
    echo "getIssuerBankCode: " . $response->getIssuerBankCode() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;

} else {
    echo "Payment fail: " . $response->getMessage() . PHP_EOL;
}