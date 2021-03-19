# Universal Time Identificator

- Time÷based sortable ID
- URL friendly, uses just 9 characters/bytes
- SHould work for more than next 500 years

Attribute          | Value                  | Note
-------------------|------------------------|-----
Alphabet base      | 6 bits                 | 2 ^ 6 = 64
Alphabet count     | 64 letters             | `-`, `0-9`, `A-Z`, `_`, `a-z`
Nanoseconds base   | 54 bits                | 6 bits per letter * 9 letters
Time sortable      | YES                    | Alphabet is in ASCII order

**Examples:**

ID                 | Nanoseconds            | Date and time
-------------------|------------------------|--------------
`4jT09VzfN`        | 01 616 145 904 040 664 | Fri Mar 19 2021 09:25:04.040664 GMT+0000
`4p6ZWOQk-`        | 01 640 995 200 000 000 | Sat Jan 01 2022 00:00:00.000000 GMT+0000
`V---------` (max) | 18 014 398 509 481 984 | Mon Nov 07 2540 23:35:09.481984 GMT+0000

---

## Instal with Composer

Edit `composer.json`:

```json
{
    ...,
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/attitude/universal-time-identificator"
        }
    ],
    "require": {
        "attitude/universal-time-identificator": "dev-main"
    }
}
```

## Usage

```php
<?php require 'vendor/autoload.php'; // When used with composer

echo UniversalTime\Identificator\UTID::decode('4jT09VzfN');
// 1616145904040664

echo UniversalTime\Identificator\UTID::encode(1640991600000000);
// 4p6bryL--

```

## Why not just use UUID v1?

No special reason. UTID je ment for small projects that don't require extra info
embeded in the UUID.

---

*Enjoy!*

---

Created by [martin_adamko](https://twitter.com/martin_adamko)
