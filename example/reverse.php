<?php

require 'init.php';

$gateway->setReferenceNumber(date("Ymdhis"));

// The transaction number to be used for return, reverse(void), and inquire(fetch) methods
$gateway->setOriginalReferenceNumber("00120250109210408000");
$gateway->setMsisdn("905322108110");

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