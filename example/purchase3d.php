<?php

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20

# https://paycell.com.tr/test-kredi-kartlari
$response = $gateway->purchase3d([
    'amount' => '1.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '5406675406675403',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '000' 
    ],
    // "installment" => 0,
    "returnUrl" => "http://local.paycell/callback.php"
])->send();



if ($response->isSuccessful()) {

    
    echo "Purchase 3D Successful" . PHP_EOL;

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

    echo PHP_EOL;

    sleep(5);

    if($response->isRedirect()) {
        echo "Please wait..." . PHP_EOL;
        echo $response->getRedirectData();
        exit;
    }

} else {
    echo "Purchase 3D fail: " . $response->getMessage() . PHP_EOL;
}
