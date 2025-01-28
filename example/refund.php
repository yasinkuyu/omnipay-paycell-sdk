<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$gateway->setOriginalReferenceNumber($paymentReferenceNumber);
$gateway->setMsisdn("905355106190");

$response = $gateway->refund([
    'amount' => '1.00',
    'currency' => 'TRY',
])->send();

if ($response->isSuccessful()) {

    echo "Refund Successful" . PHP_EOL;


    echo "getMessage: " . $response->getResponseDescription() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;
    echo "getPaymentReferenceNumber: " . $response->getPaymentReferenceNumber() . PHP_EOL;
    echo "getPaymentDate: " . $response->getPaymentDate() . PHP_EOL;
    echo "getStatus: " . $response->getStatus() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;



} else {
    echo "Refund fail: ";
    echo "<br>";

    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;
}

echo "\nRefund Response Raw Data:\n";
print_r($response->getData());