<?php

require 'init.php';

// Error: There was an invalid parameter 
// Min length 20
$gateway->setReferenceNumber(date("Ymdhissss")); // unique transaction reference number, order number etc... 
$gateway->setHostAccount("yasinkuyu@gmail.com");
$gateway->setPaymentSecurity("NON_THREED_SECURE"); // THREED_SECURE
$gateway->setLanguage("tr");

$gateway->setReturnUrl("http://localhost:4200/?trackingId=[paymentReferenceNumber]");
$gateway->setPostResultUrl("http://localhost:4200/handleInitResult.php");

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

    // Status’ten gelecek sonuç enum tipindedir. 0 için SUCCESS, 1 için PENDING, 2 için CANCELLED ve 3 için NOTFOUND değerlerinden biridir.


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
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getExtraParameters: " . $response->getExtraParameters() . PHP_EOL;
    echo "getOrderId: " . $response->getOrderId() . PHP_EOL;
    echo "getAcquirerBankCode: " . $response->getAcquirerBankCode() . PHP_EOL;
    echo "getIssuerBankCode: " . $response->getIssuerBankCode() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
   
} else {
    echo "Purchase fail: " . $response->getMessage() . PHP_EOL;
}
