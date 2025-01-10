# Omnipay: Paycell SDK

**Turkcell Paycell SDK gateway for Omnipay payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP 8.1.x. This package implements Turkcell Paycell support for Omnipay.

## Installation

```bash
composer require league/omnipay yasinkuyu/omnipay-paycell-sdk
```

Required additional dependencies:

```bash
composer require php-http/curl-client guzzlehttp/psr7 php-http/message
```

## Test Mode

To enable test mode, set the following in your initialization:

```php
$gateway->setTestMode(true); // For test environment
$gateway->setTestMode(false); // For production environment
```

Test mode uses different endpoints and credentials:

- Test URL: https://websdktest.turkcell.com.tr
- Production URL: https://paycellsdk.paycell.com.tr

## Test Environment Credentials

- Application name: PAYCELLTEST
- Application password: PaycellTestPassword
- Secure code: PAYCELL12345
- Eulaid: 17
- Merchant Code: 9998
- Terminal Code: [Get from Paycell]

## Basic Usage

### Initialize Gateway

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paycell');
$gateway->setTestMode(true); // Enable test mode
$gateway->setApplicationName('PAYCELLTEST');
$gateway->setApplicationPwd('PaycellTestPassword');
$gateway->setSecureCode('PAYCELL12345');
$gateway->setEulaID(17);
$gateway->setMerchantCode(9998);
$gateway->setTerminalCode('XXXXXXXXX');
```

### Process Purchase

```php
$transactionDateTime = date('YmdHis') . substr(microtime(), 2, 3);

$gateway->setReferenceNumber($transactionDateTime);
$gateway->setHostAccount("customer@email.com");
$gateway->setPaymentSecurity("NON_THREED_SECURE"); // or "THREED_SECURE"
$gateway->setLanguage("tr");

$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
])->send();

if ($response->isSuccessful()) {
    echo "Payment successful!";
    // Get tracking URL for redirect
    $trackingUrl = $response->getTrackingUrl();
}
```

### Query Transaction Status

```php
$response = $gateway->query([
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();

if ($response->isSuccessful()) {
    echo "Transaction status: " . $response->getMessage();
}
```

### Process Refund

```php
$response = $gateway->refund([
    'amount' => '10.00',
    'currency' => 'TRY',
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();
```

### Process Reverse (Cancel)

```php
$response = $gateway->reverse([
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();
```

## Supported Methods

- Purchase (Regular and 3D Secure)
- Query Transaction Status
- Refund
- Reverse (Cancel)

## Test Cards

For test credit cards, visit: https://paycell.com.tr/test-kredi-kartlari

## System Requirements

- PHP >= 8.1.0
- Composer
- PHP cURL extension

## Support

- For general questions, use [Stack Overflow](http://stackoverflow.com/questions/tagged/omnipay) with the `omnipay` tag
- Report bugs via [GitHub Issues](https://github.com/yasinkuyu/omnipay-paycell-sdk/issues)
- Technical support: paycelldev@paycell.com.tr

## Documentation

For detailed integration information and API documentation, please visit [Paycell SDK Documentation](https://paycell.com.tr/paycell-sdk).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
