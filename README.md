# Sylius Paybox Bundle by Gontran [![License](https://img.shields.io/packagist/l/gontran/sylius-paybox.svg)](https://packagist.org/packages/gontran/sylius-paybox) [![Version](https://img.shields.io/packagist/v/gontran/sylius-paybox.svg)](https://packagist.org/packages/gontran/sylius-paybox)

Paybox gateway for Sylius projects.

This plugin has been generated thanks to the payum composer Skeleton and thanks to [remyma/payum-paybox extension](https://github.com/remyma/payum-paybox)

## Usage

1. Install this bundle:

    ```bash
    $ composer require gontran/sylius-paybox-bundle
    ```

2. In order to allow a previous denied/canceled payment to be completed, change payment state machine by importing config file in your `app/config/config.yml`

    ```
    imports:
        - { resource: "@GontranSyliusPayboxBundle/Resources/config/app/config.yml" }
    ```

3. Configure payment method in Sylius Admin panel

## Complementary documentation

- [Sylius Payments](http://docs.sylius.org/en/latest/book/orders/payments.html)
- [Payum](https://github.com/Payum/Payum/blob/master/docs/index.md)
