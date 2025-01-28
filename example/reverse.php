<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$gateway->setOriginalReferenceNumber($paymentReferenceNumber);
$gateway->setMsisdn("905355106190");

$response = $gateway->reverse()->send();

if ($response->isSuccessful()) {
    echo "Reverse Successful" . PHP_EOL;
    echo "<br>";
    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;

    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;
} else {
    echo "Reverse fail: " . PHP_EOL;
    echo "<br>";

    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;
}

echo "<br>";
echo "<details><summary>Reverse Response Raw Data</summary>";
echo "<pre class='raw_data'><code>";
print_r($response->getData());
echo "</code></pre>";
echo "</details>";