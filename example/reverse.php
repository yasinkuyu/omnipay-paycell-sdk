<?php

require 'init.php';

$gateway->setOriginalReferenceNumber("00120250110073942398");
$gateway->setMsisdn("905355106190");

$response = $gateway->reverse()->send();

if ($response->isSuccessful()) {

    echo "Reverse Successful" . PHP_EOL;

    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getMessage: " . $response->getMessage() . PHP_EOL;

    echo "getRetryStatusDescription: " . $response->getRetryStatusDescription() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
    echo "getRetryStatusCode: " . $response->getRetryStatusCode() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;

} else {
    echo "Reverse fail: " . $response->getMessage();
}


echo "\nReverse Response Raw Data:\n";
print_r($response->getData());
