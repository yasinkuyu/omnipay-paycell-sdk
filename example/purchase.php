<?php

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20

$transactionDateTime = date('YmdHis') . substr(microtime(), 2, 3);

$gateway->setReferenceNumber($transactionDateTime); // unique transaction reference number, order number etc... 
$gateway->setHostAccount("xxxxxx@xxxx.com");
$gateway->setPaymentSecurity("NON_THREED_SECURE"); // THREED_SECURE
$gateway->setLanguage("tr");

$gateway->setReturnUrl("http://localhost:8002/query.php?paymentReferenceNumber=[paymentReferenceNumber]");
$gateway->setPostResultUrl("http://localhost:8002/handleInitResult.php");

$gateway->setInstallmentPlan(
    array(
        // array(
        //     'lineId' => 1,
        //     'paymentMethodType' => 'CREDIT_CARD',
        //     'cardBrand' => 'BONUS',
        //     'count' => 1,
        //     'amount' => 10, // 10.00 TRY İlgili taksit adedi için satış tutarı. Eğer farklı ödeme araçları için farklı fiyat kullanılmak istenirse ilgili ödeme aracı için installmentPlan değişkenine count=1 olarak bilgi eklenir. Bu değerin son iki hanesi kuruşu ifade eder.	
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

    if ($response->getTrackingUrl()) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function() {';
        echo 'var paymentWindow = window.open("_self", "_self");';
        echo 'paymentWindow.location.href = "' . $response->getTrackingUrl() . '";';
        echo '}, 1000);';        
        echo '</script>';
    } else {
        echo "Tracking URL not available" . PHP_EOL;
    }
    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
    echo "ReferenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;

    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    
   
} else {
    echo "Purchase fail: " . $response->getMessage() . PHP_EOL;
}
