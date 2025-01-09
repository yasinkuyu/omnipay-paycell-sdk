# Omnipay: Paycell SDK

**Turkcell Paycell SDK gateway for Omnipay payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP 8.1.x. This package implements Turkcell Paycell support for Omnipay.

## Important Notes

- Please review [Paycell SDK Documentation](https://paycell.com.tr/paycell-sdk) before starting integration
- Check "Service Access and General Information" section for critical integration points
- This package uses RESTful JSON service examples
- For integration support: paycelldev@paycell.com.tr

## Installation

```bash
composer require league/omnipay yasinkuyu/omnipay-paycell-sdk
```

Required additional dependencies:

```bash
composer require php-http/curl-client guzzlehttp/psr7 php-http/message
```

## Test Environment Credentials

- Application name: PAYCELLTEST
- Application password: PaycellTestPassword
- Secure code: PAYCELL12345
- Eulaid: 17
- Merchant Code: 9998

## Supported Methods

- Purchase
- Purchase with 3D Secure
- Inquiry (Transaction Status)
- Refund
- Reverse (Cancel)

## Basic Usage

1. Navigate to example directory:

```bash
cd /YOUR-PATH/vendor/yasinkuyu/omnipay-paycell-sdk/example
```

2. Copy `init.php.example` to `init.php`

3. Start test server:

```bash
php -S localhost:8000
```

4. Open test page in browser: `http://localhost:8000/purchase.php`

## Test Cards

For test credit cards, visit: https://paycell.com.tr/test-kredi-kartlari

## System Requirements

- PHP >= 8.1.0
- Composer

## Support

- For general questions, use [Stack Overflow](http://stackoverflow.com/) with the [omnipay](http://stackoverflow.com/questions/tagged/omnipay) tag
- Report bugs via [GitHub Issues](https://github.com/yasinkuyu/omnipay-paycell-sdk/issues)
- Technical support: paycelldev@paycell.com.tr

## Documentation

For detailed integration information and API documentation, please visit [Paycell SDK Documentation](https://paycell.com.tr/paycell-sdk).

## Paycell API

- [Paycell API](https://github.com/yasinkuyu/omnipay-paycell)
