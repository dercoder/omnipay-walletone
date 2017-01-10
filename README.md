# Omnipay: Wallet One

**Wallet One driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/dercoder/omnipay-walletone.svg?branch=master)](https://travis-ci.org/dercoder/omnipay-walletone)
[![Coverage Status](https://coveralls.io/repos/dercoder/omnipay-walletone/badge.svg?branch=master&service=github)](https://coveralls.io/github/dercoder/omnipay-walletone?branch=master)

[![Latest Stable Version](https://poser.pugx.org/dercoder/omnipay-walletone/v/stable.png)](https://packagist.org/packages/dercoder/omnipay-walletone)
[![Total Downloads](https://poser.pugx.org/dercoder/omnipay-walletone/downloads.png)](https://packagist.org/packages/dercoder/omnipay-walletone)
[![Latest Unstable Version](https://poser.pugx.org/dercoder/omnipay-walletone/v/unstable.png)](https://packagist.org/packages/dercoder/omnipay-walletone)
[![License](https://poser.pugx.org/dercoder/omnipay-walletone/license.png)](https://packagist.org/packages/dercoder/omnipay-walletone)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements [Wallet One](http://www.walletone.com) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "dercoder/omnipay-walletone": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Wallet One

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/dercoder/omnipay-walletone/issues),
or better yet, fork the library and submit a pull request.