<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$response = $gateway->query([
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();

if ($response->isSuccessful()) {

    echo "3D Payment Successful" . PHP_EOL;

    echo PHP_EOL;

    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
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
    echo "3D Payment fail: " . $response->getMessage() . PHP_EOL;
}
