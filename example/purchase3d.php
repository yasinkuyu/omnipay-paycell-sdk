<?php

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20

# https://paycell.com.tr/test-kredi-kartlari
$response = $gateway->purchase3d([
    'amount' => '100.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '5571135571135575',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '000' // 3D secure code 123456
    ], 
    // "installment" => 0,
    "returnUrl" => "https://insya.com/paycell/callback.php" // Must be defined in the Paycell system
])->send();

if ($response->isSuccessful()) {
    
    echo "Purchase 3D start was successful" . PHP_EOL;

    echo PHP_EOL;

    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
    echo "ReferenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;
    echo "getThreeDSessionId: " . $response->getThreeDSessionId() . PHP_EOL;
    echo "getCardToken: " . $response->getCardToken() . PHP_EOL;
    echo "getHashData: " . $response->getHashData() . PHP_EOL;

    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getExtraParameters: " . $response->getExtraParameters() . PHP_EOL;

    echo PHP_EOL;

    if($response->isRedirect()) {
        echo "Please wait..." . PHP_EOL;
        echo $response->getRedirectData();
        exit;
    }

} else {
    echo "Purchase 3D start failed: " . $response->getMessage() . PHP_EOL;

}
