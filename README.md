# Omnipay: Paycell SDK

### Turkcell Paycell SDK gateway for Omnipay payment processing library

[![Latest Stable Version](https://poser.pugx.org/yasinkuyu/omnipay-paycell-sdk/v/stable)](https://packagist.org/packages/yasinkuyu/omnipay-paycell-sdk)
[![Total Downloads](https://poser.pugx.org/yasinkuyu/omnipay-paycell-sdk/downloads)](https://packagist.org/packages/yasinkuyu/omnipay-paycell-sdk)
[![Latest Unstable Version](https://poser.pugx.org/yasinkuyu/omnipay-paycell-sdk/v/unstable)](https://packagist.org/packages/yasinkuyu/omnipay-paycell-sdk)
[![License](https://poser.pugx.org/yasinkuyu/omnipay-paycell-sdk/license)](https://packagist.org/packages/yasinkuyu/omnipay-paycell-sdk)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 8.1.x. This package implements Turkcell Paycell support for Omnipay.

# Readme TR

## Installation

    composer require league/omnipay yasinkuyu/omnipay-paycell-sdk


    ```
      Uncaught Http\Discovery\Exception\DiscoveryFailedException: Could not find resource using any discovery strategy. Find more information at http://docs.php-http.org/en/latest/discovery.html#common-errors

      composer require php-http/curl-client guzzlehttp/psr7 php-http/message
    ```

    Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
    to your `composer.json` file:

    ```json
    {
      "require": {
        "yasinkuyu/omnipay-paycell-sdk": "^3.0"
      }
    }
    ```

    And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

    The following gateways are provided by this package:

    cd /YOUR-PATH/vendor/yasinkuyu/omnipay-paycell-sdk/example

    Change init.php.example to init.php

    - php -S localhost:8000

      PHP 8.3.6 Development Server (http://localhost:8000) started

      http://localhost:8000/payment.php

## Gateway Methods

    Purchase (Satış)
    Purchase 3D
    Inquiry (Fetch: Bilgi)
    Refund (İade)
    Reverse (İptal)

    - purchase($options) - authorize and immediately capture an amount on the customer's card
    - refund($options) - refund an already processed transaction

    etc..

    For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
    repository.

## Description

```
  - Entegrasyona başlamadan önce menüde bulunan API Entegrasyonu sekmesindeki Genel Özellikler ve kullanmak istediğiniz fonksiyonlar için Fonksiyon Listesi bölümlerini incelemeniz faydalı olacaktır.
  - Entegrasyon sırasında kritik noktalar için Servis Erişim ve Genel Bilgiler sekmesindeki Entegrasyona Ait Önemli Notlar ve Gerekli Tanımlamalar kısmını kontrol etmeniz gerekmektedir.
  - Entegrasyona başlarken öncelikle çalışacağınız servis yöntemini belirlemelisiniz. SOAP tabanlı çalışacaksanız menüde bulunan SOAP Tabanlı XML Servis Örnekleri sekmesine, RESTFUL tabanlı çalışacaksanız menüde bulunan RESTFUL Tabanlı JSON Servis Örnekleri sekmesine bakmanız gerekecektir.
  - Eğer bir PAYCELL SDK müşterisiyseniz size verilen test bilgileri ile ilerleyebilirsiniz ya da Servis Erişim ve Genel Bilgiler sekmesinden test için kullanabileceğiniz default bilgilere erişebilirsiniz.
  - İşlem ya da kart ekleme adımlarında 3D yöntemini kullanacaksanız, API Entegrasyonu menüsünde bulunan 3D Yönlendirme Sayfası başlığını incelemelisiniz.
  - Hazır olarak sunulan JAVA, .NET, NODE JS, PYTHON dillerinde yazılmış projeleri Örnek Kodlar sayfasında bulabilirsiniz.
  - Tüm süreç boyunca paycelldev@paycell.com.tr adresinden ya da iletişimde olduğunuz Paycell temsilcisinden destek alabilirsiniz.

  ## Test Kredi Kartları

  - Entegrasyon sürecinde kullanabileceğiniz test kredi kartlarını https://paycell.com.tr/test-kredi-kartlari sayfasında görebilirsiniz.

  ## Genel Entegrasyon TEST ve PREPROD Bilgileri

  - Test ve Prod ortamda kullanılacak değerler clienta özel entegrasyon bilgileridir. Paycell ekibi ile iletişime geçilerek bu bilgilerin temin edilmesi gerekir.
    Bu dokümandaki servislerin test edilebilmesi için aşağıdaki gibi default entegrasyon değerleri verilmiştir. İlgili parametre değerleri hem TEST hem de PREPROD ortamlarımız için geçerlidir.
    - Application name: PAYCELLTEST
    - Application password: PaycellTestPassword
    - Secure code: PAYCELL12345
    - Eulaid: 17
    - Merchant Code: 9998

  ## Gerekli Tanımlamalar

  - Üye İşyeri ve Sanal Pos Bankası

  ### Parametreler

  - Entegrasyon esnasında kullanılan Paycell’e ait bazı parametreler üye işyeri sisteminde tanımlanmalıdır. - eulaId: Üye işyerinin hangi kullanıcı sözleşmesi versiyonunu kullanacağı bilgisi - Söz konusu eulaID değerine karşılık gelen kullanıcı sözleşmesi metni içeriği - Ödeme işlemlerinde üye işyeri tarafından üretilecek 20 haneli referans numarasının ilk 3 hanesi prefix değer olarak Paycell tarafından üye işyerine bildirlecektir.

  ### Üye İşyeri Bilgileri

  - Her bir üye işyeri için Sanal Pos bankasında üye işyeri oluşturma işlemi tamamlanmış olmalıdır. Üye işyerine ait bilgiler Paycell’e iletilmelidir, iletilecek bilgilerin detayı Üye İşyeri Bilgileri bölümünde detaylandırılmıştır.
  - Sanal Pos bankasında eğer gerekli ise IP yetkilendirme tanımı yapılmalıdır, burada kullanılan IP bilgisi “Paycell” IP bilgisidir. Tanım gerekli olduğu durumda paylaşılacaktır.
  - Üye işyeri 3D doğrulama yöntemi kullanacak ise bu bilgiye yönelik Sanal Pos banka sisteminde ilgili tanımlama yapılmalıdır.
  - Paycell’de üye işyeri bilgileri tanımlandığında her biri üye işyeri için “Merchant Code” değeri üretilip üye işyeri ile paylaşılmaktadır. Bu değer üye işyeri sisteminde tanımlanmalı, ödeme işlemlerinde bu değer input olarak kullanılmaktadır.
    Paycell

  ### Erişim

  - Entegrasyon aşamasında üye işyerleri Paycell ProvisionServices API’lerine erişim için bağlanacakları test, preprod, prod server IP bilgilerini Paycell’e iletmelidir. IP yetkilendirme için Paycell’de ilgili tanımlar gerçekleştirilmelidir.

  ### Yetkilendirme

  - Yapılacak işlemlerin doğru üye işyerinden gönderildiğinin kontrolü amacıyla yetkilendirme tanımlamaları yapılmalıdır. Paycell üzerinde yapılacak olan aşağıdaki tanımlamalar üye işyeri ile paylaşılıp, üye işyeri yetkilendirme parametrelerini servis implemantasyonunda kullanmalıdır.

    - Application Name
    - Application Password
    - Secure Code

  ### Parametreler

  - Entegrasyon esnasında kullanılan üye işyerine ait bazı parametreler Paycell sisteminde tanımlanmalıdır.

    - 3D doğrulama yöntemi kullanılıyor ise callbackurl
    - eulaID: Üye işyerinin hangi kullanıcı sözleşmesi versiyonunu kullanacağı bilgisi
    - Kullanıcı arayüzü web page ise getCardTokenSecure işlemi domain tanımı

  ### Üye İşyeri Bilgileri

  - Uygulama kapsamındaki her bir üye işyeri için aşağıdaki bilgiler Paycell sisteminde tanımlanmalıdır.

    - Sanal Pos bankası sisteminde tanımlı üye işyeri adı
    - Gerekli olduğu durumda önyüz ekranlarda görüntülenmek istenen üye işyeri adı
    - Sanal Pos bankası sisteminde tanımlı üye işyeri numarası
    - Sanal Pos bankası sisteminde tanımlı terminal numarası
    - Sanal Pos bankası sisteminde tanımlı API kullanıcı adı
    - Sanal Pos bankası sisteminde tanımlı API kullanıcı şifresi
    - Üye işyerinin 3D doğrulama yöntemi kullanıp kullanmadığı bilgisi
    - Üye işyeri 3D doğrulama yöntemi kullanıyorsa Sanal Pos bankası sisteminde tanımlı storekey değeri
```

## Requirements

    To use the bindings, use Composer's autoload:

    require_once('vendor/autoload.php');

Composer dependencies require a PHP version ">= 8.1.0"

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project, or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/yasinkuyu/omnipay-paycell-sdk/issues),
or better yet, fork the library and submit a pull request.
