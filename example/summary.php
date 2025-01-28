<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$gateway->setOriginalReferenceNumber($paymentReferenceNumber);
$gateway->setReconciliationDate("20250120");
$gateway->setTotalSaleAmount(1000);
$gateway->setTotalReverseAmount(200);
$gateway->setTotalRefundAmount(50);
$gateway->setTotalPreAuthAmount(300);
$gateway->setTotalPostAuthAmount(400);
$gateway->setTotalPostAuthReverseAmount(100);
$gateway->setTotalSaleCount(10);
$gateway->setTotalReverseCount(2);
$gateway->setTotalRefundCount(1);
$gateway->setTotalPreAuthCount(3);
$gateway->setTotalPostAuthCount(4);
$gateway->setTotalPreAuthReverseCount(1);
$gateway->setTotalPostAuthReverseCount(1);

$response = $gateway->summary()->send();

if ($response->isSuccessful()) {
    echo "Summary Successful" . PHP_EOL;
    echo "<br>";
    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;

    echo "getReconciliationResult: " . $response->getReconciliationResult() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
    echo "getTotalSaleAmount: " . $response->getTotalSaleAmount() . PHP_EOL;
    echo "getTotalReverseAmount: " . $response->getTotalReverseAmount() . PHP_EOL;
    echo "getTotalRefundAmount: " . $response->getTotalRefundAmount() . PHP_EOL;
    echo "getTotalPreAuthAmount: " . $response->getTotalPreAuthAmount() . PHP_EOL;
    echo "getTotalPostAuthAmount: " . $response->getTotalPostAuthAmount() . PHP_EOL;
    echo "getTotalPreAuthReverseAmount: " . $response->getTotalPreAuthReverseAmount() . PHP_EOL;
    echo "getTotalPostAuthReverseAmount: " . $response->getTotalPostAuthReverseAmount() . PHP_EOL;
    echo "getTotalSaleCount: " . $response->getTotalSaleCount() . PHP_EOL;
    echo "getTotalReverseCount: " . $response->getTotalReverseCount() . PHP_EOL;
    echo "getTotalRefundCount: " . $response->getTotalRefundCount() . PHP_EOL;
    echo "getTotalPreAuthCount: " . $response->getTotalPreAuthCount() . PHP_EOL;
    echo "getTotalPostAuthCount: " . $response->getTotalPostAuthCount() . PHP_EOL;
    echo "getTotalPreAuthReverseCount: " . $response->getTotalPreAuthReverseCount() . PHP_EOL;
    echo "getTotalPostAuthReverseCount: " . $response->getTotalPostAuthReverseCount() . PHP_EOL;

    
} else {
    echo "Reverse fail: " . PHP_EOL;
    echo "<br>";

    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;
}

echo "<br>";
echo "<details><summary>Summary Response Raw Data</summary>";
echo "<pre class='raw_data'><code>";
print_r($response->getData());
echo "</code></pre>";
echo "</details>";