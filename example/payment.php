<?php

require 'init.php';

$gateway->setMsisdn('905444170819');
$gateway->setReferenceNumber(date("Ymdhis"));

//$gateway->setThreeSecure(true);

# https://paycell.com.tr/test-kredi-kartlari
# Akbank 3D pass: a
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '5406675406675403',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '000' 
    ],

    "returnUrl" => "http://local.paycell/callback.php"
])->send();



if ($response->isSuccessful()) {

//     // Yanıt kontrolü
// if ($response->isRedirect()) {
//     // Kullanıcıyı ödeme sağlayıcısının sayfasına yönlendir
//     $response->redirect();
// } else {
//     // Hata durumu
//     echo $response->getMessage();
// }

    echo "Successful: ";
    echo PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId();
    echo PHP_EOL;
    echo "getMessage: " . $response->getMessage();
    echo PHP_EOL;
    echo "getCardToken: " . $response->getCardToken();
    echo PHP_EOL;
    echo "getHashData: " . $response->getHashData();
} elseif ($response->isRedirect()) {

    // Redirect to offsite payment gateway
    $response->redirect();

} else {
    echo "Ödeme başarısız: " . $response->getMessage();
}
echo PHP_EOL;

echo "getTransactionReference: " . $response->getTransactionReference();
echo PHP_EOL;
echo "getTransactionId: " . $response->getTransactionId();
echo PHP_EOL;
echo "orderId: " . $response->getOrderId();


// Yanıtı kontrol et
// if ($response->isSuccessful()) {
//     // Ödeme başarılı
//     print_r($response->getData());
// } elseif ($response->isRedirect()) {
//     // Ödeme yapılması için yönlendirme gerekli
//     $response->redirect();
// } else {
//     // Ödeme başarısız
//     echo $response->getMessage();
// }