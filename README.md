# masks
[![Packagist Version](https://img.shields.io/packagist/v/alvarofpp/masks)](https://packagist.org/packages/alvarofpp/masks)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/alvarofpp/laravel-masks/blob/master/LICENSE)

A package to mask your variables or model's attributes.

## Contents
  - [Install](#install)
  - [Usage](#usage)
  - [Contributing](#contributing)

## Install
Install via composer:
```bash
composer require alvarofpp/masks
```

## Usage
This package currently contains:
- Mask helper.
- Applies mask in model's attributes.

### Mask helper
- `mask(string $mask, string $value): string`

You can use this helper to apply mask in any value that you want. Example:
```php
<?php
$cpf = '12345678901';
$mask = '###.###.###-##';

echo mask($mask, $cpf);
// Result: 123.456.789-01
```

### Applies mask in model's attributes
You can use the trait `MaskAttributes` in your model to apply masks in the attributes.
Taking the example in the previous section, we can automate the masks such as:

```php
<?php

namespace App;

use Alvarofpp\Masks\Traits\MaskAttributes;
// ...

class User extends Authenticatable
{
    use MaskAttributes;

    /**
     * The attributes that should be masked.
     *
     * @var array
     */
    protected $masks = [
        'cpf' => '###.###.###-##',
        'phone' => [
            10 => '(##) ####-####',
            11 => '(##) ###-###-###',
        ],
    ];
    // ...
}
```

So if the value of `$user->cpf` is `12345678901`, you can use `$user->cpf_masked` to take the value masked.

In the `$user->phone` case, the mask will depend on the length of the value, for example:
if phone has `1234567890`, the value masked will be `(12) 3456-7890`,
but if phone has `12345678901`, the value masked will be `(12) 345-678-901`.

By default, `MaskAttributes` use the suffix `_masked`, you can change the suffix declaring `$maskSuffix`:
```php
<?php

namespace App;

use Alvarofpp\Masks\Traits\MaskAttributes;
// ...

class User extends Authenticatable
{
    use MaskAttributes;

    /**
     * Indicates the suffix of masked attributes.
     * 
     * @var string 
     */
    protected $maskSuffix = '_formatted';

    /**
     * The attributes that should be masked.
     *
     * @var array
     */
    protected $masks = [
        'cpf' => '###.###.###-##',
    ];
    // ...
}
```

That way, you use `$user->cpf_formatted` to grab the masked value.

## Contributing
Contributions are more than welcome. Fork, improve and make a pull request. For bugs, ideas for improvement or other, please create an [issue](https://github.com/alvarofpp/laravel-masks/issues).
