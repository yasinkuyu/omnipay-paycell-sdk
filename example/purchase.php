<?php

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20

$gateway->setReferenceNumber(date("Ymdhissss")); 
$gateway->setHostAccount("xxxxxx@xxxx.com");
$gateway->setPaymentSecurity("NON_THREED_SECURE"); // THREED_SECURE
$gateway->setLanguage("tr");

$gateway->setReturnUrl("http://localhost:8000/query.php?paymentReferenceNumber=[paymentReferenceNumber]");
$gateway->setPostResultUrl("http://localhost:8000/handleInitResult.php");

$gateway->setInstallmentPlan(
    array(
        // array(
        //     'lineId' => 1,
        //     'paymentMethodType' => 'CREDIT_CARD',
        //     'cardBrand' => 'BONUS',
        //     'count' => 1,
        //     'amount' => 10, // 10.00 TRY Sales amount for the relevant installment number. If different prices are to be used for different payment instruments, information is added to the installmentPlan variable with count=1 for the relevant payment instrument. The last two digits of this value represent the cents.
        // )
    )
); 

// test scure code 1111
// test card Denizbank	5200190006338608	01	30	410	123456 (https://paycell.com.tr/test-kredi-kartlari)

$response = $gateway->purchase([
    'amount' => '1.00',
    'currency' => 'TRY',
])->send();

if ($response->isSuccessful()) {

    // The result from Status is an enum type. Values are: 0 for SUCCESS, 1 for PENDING, 2 for CANCELLED, and 3 for NOTFOUND
    echo "Purchase successful, redirect wait..." . PHP_EOL;

    echo PHP_EOL;
 
    echo "trackingId: " . $response->getTrackingId() . PHP_EOL;
    echo "trackingUrl: " . $response->getTrackingUrl() . PHP_EOL;
    echo "status: " . $response->getStatus() . PHP_EOL;

    // Handle the redirect 
    if ($response->getTrackingUrl()) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function() {';
        echo 'var paymentWindow = window.open("_self", "_self");';
        echo ' paymentWindow.location.href = "' . $response->getTrackingUrl() . '";';
        echo '}, 3000);';        
        echo '</script>';
    } else {
        echo "Tracking URL not available" . PHP_EOL;
    }

    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
    echo "referenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;
    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    
   
} else {
    echo "Purchase fail: " . $response->getMessage() . PHP_EOL;
}

echo "\nQuery Response Raw Data:\n";
print_r($response->getData());