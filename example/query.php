<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$gateway->setMsisdn("905355106190");

sleep(5); # Wait for 5 seconds to simulate a delay

$response = $gateway->query([
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();


if ($response->isSuccessful()) {

    echo "Query Successful" . PHP_EOL;

    echo "ReferenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;

    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getExtraParameters: " . $response->getExtraParameters() . PHP_EOL;
    echo "getCurrentStep: " . $response->getCurrentStep() . PHP_EOL;
    echo "getMdErrorMessage: " . $response->getMdErrorMessage() . PHP_EOL;
    echo "getMdStatus: " . $response->getMdStatus() . PHP_EOL;
    echo "getThreeDResult: " . $response->getThreeDResult() . PHP_EOL;
    echo "getThreeDResultDescription: " . $response->getThreeDResultDescription() . PHP_EOL;


} else {
    echo "Query fail: " . $response->getMessage() . PHP_EOL;
}

echo "\nQuery Response Raw Data:\n";
print_r($response->getData());