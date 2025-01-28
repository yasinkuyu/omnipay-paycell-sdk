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

    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getMessage: " . $response->getMessage() . PHP_EOL;

    echo "getRetryStatusDescription: " . $response->getRetryStatusDescription() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
    echo "getRetryStatusCode: " . $response->getRetryStatusCode() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;

} else {
    echo "Refund fail: " . $response->getMessage();
}

echo "\nRefund Response Raw Data:\n";
print_r($response->getData());